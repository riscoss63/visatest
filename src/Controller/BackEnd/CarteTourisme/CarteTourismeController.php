<?php 

namespace App\Controller\BackEnd\CarteTourisme;

use App\Entity\CarteTourisme;
use App\Entity\InfosEntreprise;
use App\Entity\ModeExpedition;
use App\Entity\NotreService;
use App\Form\Backend\CarteTourisme\CarteTourismeType;
use App\Form\Backend\InfosEntreprise\InfosEntrepriseType;
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
 * @Route("/gestion/carte-de-tourisme")
 */
class CarteTourismeController extends AbstractController
{

    /**
     * @Route("/infos-entreprise", name="infos_entreprise_carte_tourisme")
     */
    public function infosEntrepriseEdit(Request $request, EntityManagerInterface $manager) : Response
    {

        $infos= $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy([
            'typeVisa'      =>  'carte_tourisme'
        ]);

        if(!$infos)
        {
            $infos = new InfosEntreprise;
            $infos->setTypeVisa('carte_tourisme');
        }
        $form= $this->createForm(InfosEntrepriseType::class, $infos);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($infos);
            $manager->flush();
        }

        return $this->render('/back_end/carte_de_tourisme/infos_entreprise/infos_entreprise_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/pays/json", name="json_pays_carte_de_tourisme")
     */
    public function carteTourismeJson() : Response
    {
        $carteTourisme= $this->getDoctrine()->getRepository(CarteTourisme::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonCarteTourisme=$serializer->serialize($carteTourisme, 'json');
        //On retourne une réponse JSON
        return new Response($jsonCarteTourisme, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/pays/show", name="show_pays_carte_tourisme")
     */
    public function carteTourismeShow() : Response
    {
        return $this->render('/back_end/carte_de_tourisme/pays_carte_de_tourisme_show.html.twig');
    }

    /**
     * @Route("/add/pays", name="add_pays_carte_tourisme")
     */
    public function paysTourismeAdd(Request $request, EntityManagerInterface $manager) : Response
    {

        $carteTourisme= new CarteTourisme;

        $form=$this->createForm(CarteTourismeType::class, $carteTourisme);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($carteTourisme);
            $manager->flush();

            return $this->redirectToRoute('edit_pays_carte_tourisme', [
                'id'        => $carteTourisme->getId()
            ]);
        }

        return $this->render('/back_end/carte_de_tourisme/pays_carte_tourisme_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/pays-{id}", name="edit_pays_carte_tourisme", options={"expose"=true})
     */
    public function paysTourismeEdit(Request $request, $id, EntityManagerInterface $manager): Response
    {
        
        $carteTourisme = $this->getDoctrine()->getRepository(CarteTourisme::class)->find($id);

        $form = $this->createForm(CarteTourismeType::class, $carteTourisme);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($carteTourisme);
            $manager->flush();
        }

        return $this->render('/back_end/carte_de_tourisme/pays_carte_tourisme_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/add/mode-expedition/carte-tourisme-{id}", name="add_mode_expedition_carte_tourisme")
     */
    public function modeDexpeditionAdd(Request $request, $id, EntityManagerInterface $manager) : Response
    {   
        $carteTourisme = $this->getDoctrine()->getRepository(CarteTourisme::class)->find($id);

        $modeExpedition = new ModeExpedition;
        $modeExpedition->setVisaClassic($carteTourisme);

        $form = $this->createForm(ModeExpeditionType::class, $modeExpedition);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($modeExpedition);
            $manager->flush();
            return $this->redirectToRoute('edit_mode_expedition_carte_tourisme', [
                'id'        =>$modeExpedition->getId()
            ]);
        }
        return $this->render('/back_end/carte_de_tourisme/rubrique/edit_mode_expedition.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/mode-expedition-{id}", name="edit_mode_expedition_carte_tourisme")
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

        return $this->render('/back_end/carte_de_tourisme/rubrique/edit_mode_expedition.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/add/notre-service/carte-tourisme-{id}", name="add_notre_service_carte_tourisme")
     */
    public function notreServiceAdd(Request $request, $id, EntityManagerInterface $manager) : Response
    {   
        $carteTourisme = $this->getDoctrine()->getRepository(CarteTourisme::class)->find($id);

        $notreService = new NotreService;
        $notreService->setVisaClassic($carteTourisme);

        $form = $this->createForm(NotreServiceType::class, $notreService);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($notreService);
            $manager->flush();
            return $this->redirectToRoute('edit_notre_service_carte_tourisme', [
                'id'        =>$notreService->getId()
            ]);
        }
        return $this->render('/back_end/carte_de_tourisme/rubrique/edit_notre_service.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/notre-service-{id}", name="edit_notre_service_carte_tourisme")
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

        return $this->render('/back_end/carte_de_tourisme/rubrique/edit_notre_service.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}