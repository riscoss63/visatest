<?php

namespace App\Controller\BackEnd\Evisa;

use App\Entity\EVisa;
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
 * @Route("/gestion/volet-infos-evisa")
 */
class VoletInfosEvisaController extends AbstractController
{

    /**
     * @Route("/liste/json-{id}", name="json_volet_infos_evisa")
     */
    public function voletInfosEvisaJson($id) : Response
    {
        $eVisa= $this->getDoctrine()->getRepository(EVisa::class)->find($id);
        $voletsInfos= $eVisa->getVoletInfos();
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
     * @Route("/volets-infos-evisa-{id}", name="show_volet_infos_evisa", options={"expose"=true})
     */
    public function voletsInfoShow($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $eVisa = $this->getDoctrine()->getRepository(EVisa::class)->find($id);

        //Permet l'ajout d'un nouveau volet
        $voletInfo = new VoletInfo;
        
        $form = $this->createForm(VoletInfoVisaClassicType::class, $voletInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $voletInfo->setEVisa($eVisa);
            $manager->persist($voletInfo);
            $manager->flush();
        }

        return $this->render('/back_end/evisa/volet_infos/show_volet_infos.html.twig', [
            'evisa'      => $eVisa,
            'form'              => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/volet-infos-{id}", name="edit_volet_infos_evisa", options={"expose"=true})
     */
    public function voletInfoEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $voletInfo = $this->getDoctrine()->getRepository(VoletInfo::class)->find($id);
        $eVisa = $voletInfo->getEvisa();

        $form = $this->createForm(VoletInfoVisaClassicEditType::class, $voletInfo);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($voletInfo);
            $manager->flush();

            return $this->redirectToRoute('show_volet_infos_evisa', [
                'id'        => $eVisa->getId()
            ]);
        }

        return $this->render('/back_end/evisa/volet_infos/edit_volet_infos.html.twig', [
            'form'      =>$form->createView(),
            'voletinfo' => $voletInfo,
        ]);
    }
}