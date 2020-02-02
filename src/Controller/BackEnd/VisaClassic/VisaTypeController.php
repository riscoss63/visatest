<?php

namespace App\Controller\BackEnd\VisaClassic;

use App\Entity\VisaClassic;
use App\Entity\VisaType;
use App\Form\Backend\VisaClassic\TypeVisaClassicType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/gestion/visa-classic/type-visa")
 */
class VisaTypeController extends AbstractController
{
    private $serviceTypeVisaClassic;

    public function __construct(ServicesRepository $service)
    {   
        $this->serviceTypeVisaClassic= $service->findTypeVisaClassic();
    }

    /**
     * @Route("/liste-{id}/json", name="json_type_visa_classic")
     */
    public function typeVisaClassicJson($id) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceTypeVisaClassic);

        $visaClassic= $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);
        $typeVisaClassic= $visaClassic->getTypeVisa();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES      => ['id', 'titre', 'categorieVisa', 'typeEntre', 'dureSejour', 'active']

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonTypeVisaClassic=$serializer->serialize($typeVisaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonTypeVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * 
     * @Route("/liste/type-visa-classic-{id}", name="show_type_visa_classic", options={"expose"=true})
     */
    public function typeVisaClassicShow($id) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceTypeVisaClassic);

        $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);
        return $this->render('/back_end/visa_classic/type_visa_classic_show.html.twig', [
            'visaClassic'       =>$visaClassic
        ]);
    }

    /**
     * @Route("/add/visa-classic-{id}", name="add_type_visa_classic")
     */
    public function typeVisaClassicAdd(Request $request, EntityManagerInterface $manager, $id) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceTypeVisaClassic);

        $typeVisaClassic = new VisaType;
        $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);
        $typeVisaClassic->setVisaClassic($visaClassic);

        $form = $this->createForm(TypeVisaClassicType::class, $typeVisaClassic);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($typeVisaClassic);
            $manager->flush();

            return $this->redirectToRoute('edit_type_visa_classic', [
                'id'        =>$typeVisaClassic->getId()
            ]);
        }

        return $this->render('/back_end/visa_classic/type_visa_classic_edit.html.twig', [
            'form'      => $form->createView(),
            'id'       => $visaClassic->getId()
        ]);

    }

    /**
     * @Route("/edit/type-visa-classic-{id}", name="edit_type_visa_classic", options={"expose"=true})
     */
    public function typeVisaClassicEdit(Request $request, EntityManagerInterface $manager, $id) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceTypeVisaClassic);

        $typeVisaClassic = $this->getDoctrine()->getRepository(VisaType::class)->find($id);
        $visaClassic = $typeVisaClassic->getVisaClassic();
        $form = $this->createForm(TypeVisaClassicType::class, $typeVisaClassic);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($typeVisaClassic);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/type_visa_classic_edit.html.twig', [
            'form'      => $form->createView(),
            'id'        => $visaClassic->getId()
        ]);
    }

}