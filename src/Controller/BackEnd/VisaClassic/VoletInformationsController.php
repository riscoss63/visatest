<?php

namespace App\Controller\BackEnd\VisaClassic;

use App\Entity\VisaClassic;
use App\Entity\VoletInfo;
use App\Form\Backend\VisaClassic\VoletInfoVisaClassicEditType;
use App\Form\Backend\VisaClassic\VoletInfoVisaClassicType;
use App\Repository\ServicesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/gestion/volet-infos-visa-classic")
 */
class VoletInformationsController extends AbstractController
{
    private $serviceVoletInfoVisaClassic;

    public function __construct(ServicesRepository $service)
    {   
        $this->serviceVoletInfoVisaClassic= $service->findVoletInfoVisaClassic();

        // $this->denyAccessUnlessGranted('SHOW', $this->serviceVoletInfoVisaClassic);
    }

    /**
     * @Route("/liste-{id}", name="json_volet_infos_visa_classic")
     */
    public function voletsInfoJson($id) : Response
    {
        $visaClassic= $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);
        $voletsInfos= $visaClassic->getVoletsInfos();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES      => ['id', 'titre', 'contenu']

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonvoletsInfos=$serializer->serialize($voletsInfos, 'json');
        //On retourne une réponse JSON
        return new Response($jsonvoletsInfos, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/volets-infos-visa-classic-{id}", name="show_volet_infos_visa_classic", options={"expose"=true})
     */
    public function voletsInfoShow($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $visasClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->findAll();
        $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);

        //Permet l'ajout d'un nouveau volet
        $voletInfo = new VoletInfo;
        
        $form = $this->createForm(VoletInfoVisaClassicType::class, $voletInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $voletInfo->setVisaClassic($visaClassic);
            $manager->persist($voletInfo);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/volet_infos/show_volet_infos.html.twig', [
            'visa_classic'      =>$visaClassic,
            'form'              => $form->createView(),
            'visas'             => $visasClassic
        ]);
    }

    /**
     * @Route("/edit/volet-infos-{id}", name="edit_volet_infos_visa_classic", options={"expose"=true})
     */
    public function voletInfoEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $voletInfo = $this->getDoctrine()->getRepository(VoletInfo::class)->find($id);
        $visaClassic = $voletInfo->getVisaClassic();

        $form = $this->createForm(VoletInfoVisaClassicEditType::class, $voletInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($voletInfo);
            $manager->flush();

            return $this->redirectToRoute('show_volet_infos_visa_classic', [
                'id'        => $visaClassic->getId()
            ]);
        }

        return $this->render('/back_end/visa_classic/volet_infos/edit_volet_infos.html.twig', [
            'form'      =>$form->createView(),
            'voletinfo' => $voletInfo,
        ]);
    }

    /**
     * @Route("del/volet-infos-{id}", name="del_volet_infos_visa_classic", options={"expose"=true})
     */
    public function voletInfosDel($id, EntityManagerInterface $manager)
    {
        $voletInfo = $this->getDoctrine()->getRepository(VoletInfo::class)->find($id);
        $visaClassic = $voletInfo->getVisaClassic();
        $manager->remove($voletInfo);
        $manager->flush();

        return $this->redirectToRoute('show_volet_infos_visa_classic', [
            'id'        => $visaClassic->getId()
        ]);
    }


}