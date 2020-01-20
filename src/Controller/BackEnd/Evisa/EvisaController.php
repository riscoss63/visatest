<?php

namespace App\Controller\BackEnd\Evisa;

use App\Entity\EVisa;
use App\Entity\InfosEntreprise;
use App\Entity\ModeExpedition;
use App\Entity\NotreService;
use App\Form\Backend\InfosEntreprise\InfosEntrepriseType;
use App\Form\Backend\VisaClassic\EvisaType;
use App\Form\Backend\VisaClassic\ModeExpeditionType;
use App\Form\Backend\VisaClassic\NotreServiceType;
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
 * @Route("/gestion/evisa")
 */
class EvisaController extends AbstractController
{
    /**
     * @Route("/infos-entreprise", name="infos_entreprise_evisa")
     */
    public function infosEntrepriseEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $infos= $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy([
            'typeVisa'      =>  'evisa'
        ]);
        if(!$infos)
        {
            $infos = new InfosEntreprise;
            $infos->setTypeVisa('evisa');
        }

        $form= $this->createForm(InfosEntrepriseType::class, $infos);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($infos);
            $manager->flush();
        }

        return $this->render('/back_end/evisa/infos_entreprise/infos_entreprise.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/liste/pays-json", name="json_evisa")
     */
    public function paysClassicJson() : Response
    {
        // $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        $eVisa= $this->getDoctrine()->getRepository(EVisa::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonEVisa=$serializer->serialize($eVisa, 'json');
        //On retourne une réponse JSON
        return new Response($jsonEVisa, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/pays-evisa", name="show_pays_evisa")
     */
    public function paysClassicShow() : Response
    {
        // $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        return $this->render('/back_end/evisa/pays_evisa_show.html.twig');
    }

    /**
     * @Route("/add/pays-evisa", name="add_pays_evisa")
     */
    public function paysClassicAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        // $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        $eVisa= new EVisa;

        $form=$this->createForm(EvisaType::class, $eVisa);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($eVisa);
            $manager->flush();
            
            return $this->redirectToRoute('edit_pays_evisa', [
                'id'        => $eVisa->getId()
            ]);
        }

        return $this->render('/back_end/evisa/pays_evisa_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/pays-evisa-{id}", name="edit_pays_evisa", options={"expose"=true})
     */
    public function paysClassicEdit(Request $request, $id, EntityManagerInterface $manager): Response
    {
        // $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);
        
        $eVisa = $this->getDoctrine()->getRepository(EVisa::class)->find($id);

        $form = $this->createForm(EvisaType::class, $eVisa);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($eVisa);
            $manager->flush();
        }

        return $this->render('/back_end/evisa/pays_evisa_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/add/mode-expedition/evisa-{id}", name="add_mode_expedition_evisa")
     */
    public function modeDexpeditionAdd(Request $request, $id, EntityManagerInterface $manager) : Response
    {   
        $evisa = $this->getDoctrine()->getRepository(EVisa::class)->find($id);

        $modeExpedition = new ModeExpedition;
        $modeExpedition->setEvisa($evisa);

        $form = $this->createForm(ModeExpeditionType::class, $modeExpedition);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($modeExpedition);
            $manager->flush();
            return $this->redirectToRoute('edit_mode_expedition_evisa', [
                'id'        =>$modeExpedition->getId()
            ]);
        }
        return $this->render('/back_end/evisa/rubrique/edit_mode_expedition.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/mode-expedition-{id}/evisa", name="edit_mode_expedition_evisa")
     */
    public function modeDexpeditionEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $modeExpedition = $this->getDoctrine()->getRepository(ModeExpedition::class)->find($id);

        $form = $this->createForm(ModeExpeditionType::class, $modeExpedition);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($modeExpedition);
            $manager->flush();
        }

        return $this->render('/back_end/evisa/rubrique/edit_mode_expedition.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/add/notre-service/evisa-{id}", name="add_notre_service_evisa")
     */
    public function notreServiceAdd(Request $request, $id, EntityManagerInterface $manager) : Response
    {   
        $evisa = $this->getDoctrine()->getRepository(EVisa::class)->find($id);

        $notreService = new NotreService;
        $notreService->setEvisa($evisa);

        $form = $this->createForm(NotreServiceType::class, $notreService);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($notreService);
            $manager->flush();
            return $this->redirectToRoute('edit_notre_service_evisa', [
                'id'        =>$notreService->getId()
            ]);
        }
        return $this->render('/back_end/evisa/rubrique/edit_notre_service.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/notre-service-{id}", name="edit_notre_service_evisa")
     */
    public function notreServiceEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $notreService = $this->getDoctrine()->getRepository(NotreService::class)->find($id);

        $form = $this->createForm(NotreServiceType::class, $notreService);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($notreService);
            $manager->flush();
        }

        return $this->render('/back_end/evisa/rubrique/edit_notre_service.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}