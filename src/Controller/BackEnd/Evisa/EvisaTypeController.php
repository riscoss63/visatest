<?php

namespace App\Controller\BackEnd\Evisa;

use App\Entity\CategorieVisa;
use App\Entity\EVisa;
use App\Entity\VisaType;
use App\Form\Backend\VisaClassic\TypeVisaClassicType;
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
 * @Route("/gestion/evisa/type-visa")
 */
class EvisaTypeController extends AbstractController
{
    /**
     * @Route("/liste-{id}/json", name="json_type_evisa")
     */
    public function typeEvisaJson($id) : Response
    {

        $eVisa= $this->getDoctrine()->getRepository(EVisa::class)->find($id);
        $typeEVisa= $eVisa->getTypeVisa();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES      => ['id', 'titre', 'categorieVisa', 'typeEntre', 'dureSejour', 'active']

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonTypeEvisa=$serializer->serialize($typeEVisa, 'json');
        //On retourne une réponse JSON
        return new Response($jsonTypeEvisa, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * 
     * @Route("/liste/type-evisa-{id}", name="show_type_evisa", options={"expose"=true})
     */
    public function typeEvisaShow($id) : Response
    {

        $eVisa = $this->getDoctrine()->getRepository(EVisa::class)->find($id);
        return $this->render('/back_end/evisa/type_evisa_show.html.twig', [
            'eVisa'       =>$eVisa
        ]);
    }

    /**
     * @Route("/add/evisa-{id}", name="add_type_evisa")
     */
    public function typeEvisaAdd(Request $request, EntityManagerInterface $manager, $id) : Response
    {
        // $this->denyAccessUnlessGranted('SHOW', $this->serviceTypeVisaClassic);

        $typeEvisa = new VisaType;
        $eVisa = $this->getDoctrine()->getRepository(EVisa::class)->find($id);
        $typeEvisa->setEVisa($eVisa);

        $form = $this->createForm(TypeVisaClassicType::class, $typeEvisa);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($typeEvisa);
            $manager->flush();
            $this->addFlash('success', 'Type d\'evisa ajouter');
            return $this->redirectToRoute('edit_type_evisa', [
                'id'        =>$typeEvisa->getId()
            ]);
        }

        return $this->render('/back_end/evisa/type_evisa_edit.html.twig', [
            'form'      => $form->createView(),
            'id'        => $eVisa->getId()
        ]);

    }

    /**
     * @Route("/edit/type-evisa-{id}", name="edit_type_evisa", options={"expose"=true})
     */
    public function typeVisaClassicEdit(Request $request, EntityManagerInterface $manager, $id) : Response
    {
        // $this->denyAccessUnlessGranted('SHOW', $this->serviceTypeVisaClassic);

        $typeEvisa = $this->getDoctrine()->getRepository(VisaType::class)->find($id);
        $evisa = $typeEvisa->getEVisa();
        $form = $this->createForm(TypeVisaClassicType::class, $typeEvisa);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($typeEvisa);
            $manager->flush();
            $this->addFlash('success', 'Type d\'evisa modifier');

        }

        return $this->render('/back_end/evisa/type_evisa_edit.html.twig', [
            'form'      => $form->createView(),
            'id'        => $evisa->getId()
        ]);
    }
}