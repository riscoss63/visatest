<?php

namespace App\Controller\BackEnd\Actualites;

use App\Entity\Actualite;
use App\Entity\Continent;
use App\Form\Backend\Actualite\ActualiteType;
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
 * @Route("/gestion/actualites")
 */
class ActualiteController extends AbstractController
{

    /**
     * @Route("/json", name="json_actualite")
     */
    public function actualiteJson() : Response
    {
        $actualite = $this->getDoctrine()->getRepository(Actualite::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonActualite=$serializer->serialize($actualite, 'json');
        //On retourne une réponse JSON
        return new Response($jsonActualite, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/show", name="show_actualite")
     */
    public function actualiteList() : Response
    {
        return $this->render('/back_end/actualite/actualite_show.html.twig');
    }

    /**
     * @Route("/add", name="add_actualite")
     */
    public function actualiteAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $actualite = new Actualite;

        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($actualite);
            $manager->flush();
            return $this->redirectToRoute('edit_actualite', [
                'id'        => $actualite->getId()
            ]);
        }

        return $this->render('/back_end/actualite/actualite_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/actualite-{id}", name="edit_actualite", options={"expose"=true})
     */
    public function actualiteEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $actualite = $this->getDoctrine()->getRepository(Actualite::class)->find($id);

        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $actualite->setDateModification(new \DateTime('now'));
            
            $manager->persist($actualite);
            $manager->flush();
        }

        return $this->render('/back_end/actualite/actualite_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/del/actualite-{id}", name="del_actualite", options={"expose"=true})
     */
    public function actualiteDel($id, EntityManagerInterface $manager)
    {
        $actualite = $this->getDoctrine()->getRepository(Actualite::class)->find($id);

        if($actualite)
        {
            $manager->remove($actualite);
            $manager->flush();
        }

        return $this->redirectToRoute('show_actualite');
    }
    
    /**
     * @Route("/actualite-{id}", name="actualite_show")
     */
    public function actualiteShow($id) : Response
    {
        $continents = $this->getDoctrine()->getRepository(Continent::class)->findAll();

        
        $visasClassics=[];
        $eVisas=[];
        
        foreach ($continents as $continent) 
        {
            $zones = $continent->getZonesGeographique();
            foreach($zones as $zone)
            {
                $plusieursPays = $zone->getPays();

                foreach ($plusieursPays as $pays) 
                {
                    $visaClassicc=$pays->getVisaClassic();
                    $evisaa = $pays->getEVisa();
                    $zoneAdd=$pays->getZoneGeographique();
                    if($visaClassicc)
                    {
                        $visasClassics[] = $continent;
                    }
                    if($evisaa)
                    {
                        $eVisas[] = $continent;
                    }

                }

            }

        }

        $actualites = $this->getDoctrine()->getRepository(Actualite::class)->findAll();
        $actualitesGeneral = [];
        foreach ($actualites as $actualite) 
        {
            
            if(!$actualite->getVisaClassic() AND !$actualite->getEvisa() AND !$actualite->getCarteTourisme())
            {
                $actualitesGeneral[] = $actualite;
            }
        }
        $actualite = $this->getDoctrine()->getRepository(Actualite::class)->find($id);
        return $this->render('/front_end/actualite/actualite_show.html.twig', [
            'actualite'     => $actualite,
            'actualites'    => $actualites,
            'actualites_general'       => $actualitesGeneral,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
        ]);
    }
}