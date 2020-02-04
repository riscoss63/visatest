<?php

namespace App\Controller\BackEnd\Evisa\Demandes;

use App\Entity\Course;
use App\Entity\Demande;
use App\Entity\EtatDossier;
use App\Entity\ReceptionDossier;
use App\Entity\Voyageurs;
use App\Form\Backend\Evisa\DemandeEvisaAdresserType;
use App\Form\Backend\VisaClassic\CompletReceptionType;
use App\Form\Backend\VisaClassic\DemandeType;
use App\Form\Backend\VisaClassic\EtatDossierType;
use App\Form\Backend\VisaClassic\IncompletReceptionType;
use App\Form\Backend\VisaClassic\VoyageursType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/gestion/demandes/evisa")
 */
class DemandesController extends AbstractController
{
    /**
     * @Route("/liste/json-demandes", name="json_demandes_evisa")
     */
    public function demandesJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande')
            {
                $evisa = $demande->getVisaType()->getEVisa();
                if($evisa)
                {
                    $demandesEvisa[] = $demande;
                }
            }
            
            $demandesEvisa;
        }
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesEvisa=$serializer->serialize($demandesEvisa, 'json');
        //On retourne une réponse JSON
        return new Response($jsonDemandesEvisa, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes/demandes-evisa", name="show_demandes_evisa")
     */
    public function demandesShow() : Response
    {
        return $this->render('/back_end/evisa/demandes/show_demandes.html.twig');
    }

    /**
     * @Route("/edit/demande-evisa-{id}", name="edit_demandes_evisa", options={"expose" = true})
     */
    public function demandeEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($demande);
            $manager->flush();

            return $this->redirectToRoute('show_demandes_evisa');
        }

        return $this->render('/back_end/evisa/demandes/edit_demandes.html.twig', [
            'form'      => $form->createView(),
            'demande'   => $demande
        ]);
    }

    /**
     * @Route("/edit/voyageur-{id}", name="edit_voyageur_evisa", options={"expose"=true})
     */
    public function voyageurEdit($id, EntityManagerInterface $manager, Request $request)
    {
        $voyageur = $this->getDoctrine()->getRepository(Voyageurs::class)->find($id);

        $form = $this->createForm(VoyageursType::class, $voyageur);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($voyageur);
            $manager->flush();

        }
        return $this->render('/back_end/evisa/demandes/edit_voyageurs.html.twig', [
            'form'      => $form->createView(),
            'id'        => $voyageur->getId(),
            'voyageur'  => $voyageur
        ]);
    }
    
    /**
     * @Route("/adresser/evisa", name="adresser-evisa")
     */
    public function evisaAdresser(Request $request, EntityManagerInterface $manager)
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();

        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'encours')
            {
                $evisa = $demande->getVisaType()->getEVisa();
                if($evisa)
                {
                    $demandesEvisa[] = $demande;
                }
            }
            
            $demandesEvisa;
        }
        
        $form = $this->createFormBuilder($demandesEvisa)
            ->add('demandes', CollectionType::class, [
                'entry_type'    => DemandeEvisaAdresserType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'required'      => false,
                'attr'          => [
                    'class' => 'my-selector form',
                ],
                'by_reference'    =>false
            ])
            ->getForm();
        ;
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($demandesEvisa);
            $manager->flush();
        }

        return $this->render('/back_end/evisa/demandes/adresser_evisa.html.twig', [
            'form'      => $form->createView(),
            'demandes'  => $demandesEvisa
        ]);
    }

}