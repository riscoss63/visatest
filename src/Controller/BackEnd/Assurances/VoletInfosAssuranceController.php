<?php

namespace App\Controller\BackEnd\Assurances;

use App\Entity\Assurance;
use App\Entity\EVisa;
use App\Entity\PageAssurance;
use App\Entity\VoletInfo;
use App\Form\Backend\VisaClassic\VoletInfoVisaClassicEditType;
use App\Form\Backend\VisaClassic\VoletInfoVisaClassicType;
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
 * @Route("/gestion/volet-infos-assurance")
 */
class VoletInfosAssuranceController extends AbstractController
{

    /**
     * @Route("/liste/json", name="json_volet_infos_assurance")
     */
    public function voletInfosEvisaJson() : Response
    {
        $assurance= $this->getDoctrine()->getRepository(PageAssurance::class)->find(1);
        $voletsInfos= $assurance->getVoletInfo();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonvoletsInfos=$serializer->serialize($voletsInfos, 'json');
        //On retourne une réponse JSON
        return new Response($jsonvoletsInfos, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/volets-infos-assurance", name="show_volet_infos_assurance", options={"expose"=true})
     */
    public function voletsInfoShow(Request $request, EntityManagerInterface $manager) : Response
    {
        $assurance = $this->getDoctrine()->getRepository(PageAssurance::class)->find(1);

        //Permet l'ajout d'un nouveau volet
        $voletInfo = new VoletInfo;
        
        $form = $this->createForm(VoletInfoVisaClassicType::class, $voletInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $voletInfo->setPageAssurance($assurance);
            $manager->persist($voletInfo);
            $manager->flush();
        }

        return $this->render('/back_end/assurance/volet_infos/show_volet_infos.html.twig', [
            'assurance'             => $assurance,
            'form'              => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/volet-infos-{id}", name="edit_volet_infos_assurance", options={"expose"=true})
     */
    public function voletInfoEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $voletInfo = $this->getDoctrine()->getRepository(VoletInfo::class)->find($id);
        $assurance = $voletInfo->getPageAssurance();

        $form = $this->createForm(VoletInfoVisaClassicEditType::class, $voletInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($voletInfo);
            $manager->flush();

            return $this->redirectToRoute('show_volet_infos_assurance', [
                'id'        => $assurance->getId()
            ]);
        }

        return $this->render('/back_end/assurance/volet_infos/edit_volet_infos.html.twig', [
            'form'      =>$form->createView(),
            'voletinfo' => $voletInfo,
        ]);
    }
}