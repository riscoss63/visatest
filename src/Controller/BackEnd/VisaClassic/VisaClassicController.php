<?php

namespace App\Controller\BackEnd\VisaClassic;

use App\Entity\InfosEntreprise;
use App\Entity\ModeExpedition;
use App\Entity\NotreService;
use App\Entity\VisaClassic;
use App\Form\Backend\InfosEntreprise\BonDeCommandeEntrepriseType;
use App\Form\Backend\InfosEntreprise\InfosEntrepriseType;
use App\Form\Backend\VisaClassic\ModeExpeditionType;
use App\Form\Backend\VisaClassic\NotreServiceType;
use App\Form\Backend\VisaClassic\VisaClassicType;
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
 * @Route("/gestion/visa-classic")
 */
class VisaClassicController extends AbstractController
{

    private $servicePaysVisaClassic;
    private $serviceInfosEntreprise;

    public function __construct(ServicesRepository $service)
    {   
        $this->servicePaysVisaClassic= $service->findPaysVisaClassic();
        $this->serviceInfosEntreprise= $service->findInfosEntrepriseVisaClassic();
    }

    /**
     * @Route("/entreprise/infos", name="infos_entreprise_visa_classic")
     */
    public function infosEntrepriseEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceInfosEntreprise);

        $infos= $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy([
            'typeVisa'      =>  'visa_classic'
        ]);

        if(!$infos)
        {
            $infos = new InfosEntreprise;
            $infos->setTypeVisa('visa_classic');
        }
        $form= $this->createForm(InfosEntrepriseType::class, $infos);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($infos);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/infos_entreprise/infos_entreprise_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/entreprise/bons-de-commande", name="bon_de_commande_entreprise_visa_classic")
     */
    public function bonDeCommandeEdit(Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        $bonDeCommande= $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy([
            'typeVisa'      =>  'visa_classic'
        ]);
        if(!$bonDeCommande)
        {
            $bonDeCommande = new InfosEntreprise;
            $bonDeCommande->setTypeVisa('visa_classic');
        }

        $form= $this->createForm(BonDeCommandeEntrepriseType::class, $bonDeCommande);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($bonDeCommande);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/infos_entreprise/bon_de_commande_entreprise_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/liste/pays-json", name="json_visa_classic")
     */
    public function paysClassicJson() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        $visaClassic= $this->getDoctrine()->getRepository(VisaClassic::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES      => ['id', 'titre', 'typeVisa', 'pays' => 'iso', 'active']

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonVisaClassic=$serializer->serialize($visaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/pays-visa-classic", name="show_pays_visa_classic")
     */
    public function paysClassicShow() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        return $this->render('/back_end/visa_classic/pays_visa_classic_show.html.twig');
    }

    /**
     * @Route("/add/pays-visa-classic", name="add_pays_visa_classic")
     */
    public function paysClassicAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);

        $visaClassic= new VisaClassic;

        $form=$this->createForm(VisaClassicType::class, $visaClassic);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($visaClassic);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/pays_visa_classic_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("edit/pays-visa-classic-{id}", name="edit_pays_visa_classic", options={"expose"=true})
     */
    public function paysClassicEdit(Request $request, $id, EntityManagerInterface $manager): Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePaysVisaClassic);
        
        $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);

        $form = $this->createForm(VisaClassicType::class, $visaClassic);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($visaClassic);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/pays_visa_classic_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/mode-expedition/visa-classic", name="edit_mode_expedition")
     */
    public function modeDexpeditionEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $modeExpedition = $this->getDoctrine()->getRepository(ModeExpedition::class)->findOneBy([
            'visaClassic'       => true
        ]);
        
        if(!$modeExpedition)
        {
            $modeExpedition = new ModeExpedition;
            $modeExpedition->setVisaClassic(true);
        }
        $form = $this->createForm(ModeExpeditionType::class, $modeExpedition);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($modeExpedition);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/rubrique/edit_mode_expedition.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/notre-service/visa-classic", name="edit_notre_service")
     */
    public function notreServiceEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $notreService = $this->getDoctrine()->getRepository(NotreService::class)->findOneBy([
            'visaClassic'       => true
        ]);
        
        if(!$notreService)
        {
            $notreService = new NotreService;
            $notreService->setVisaClassic(true);
        }

        $form = $this->createForm(NotreServiceType::class, $notreService);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($notreService);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/rubrique/edit_notre_service.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}