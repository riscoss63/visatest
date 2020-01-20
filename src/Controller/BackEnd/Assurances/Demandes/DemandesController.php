<?php

namespace App\Controller\BackEnd\Assurances\Demandes;

use App\Entity\Course;
use App\Entity\Demande;
use App\Entity\EtatDossier;
use App\Entity\ReceptionDossier;
use App\Entity\Voyageurs;
use App\Form\Backend\VisaClassic\CompletReceptionType;
use App\Form\Backend\VisaClassic\DemandeType;
use App\Form\Backend\VisaClassic\EtatDossierType;
use App\Form\Backend\VisaClassic\IncompletReceptionType;
use App\Form\Backend\VisaClassic\VoyageursType;
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
 * @Route("/gestion/demandes/evisa")
 */
class DemandesController extends AbstractController
{
    /**
     * @Route("/liste/json-demandes", name="json_demandes_assurance")
     */
    public function demandesJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande')
            {
                $assurance = $demande->getAssurance();
                if($assurance)
                {
                    $demandesAssurance[] = $demande;
                }
            }
            
            $demandesAssurance;
        }
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesAssurance=$serializer->serialize($demandesAssurance, 'json');
        //On retourne une réponse JSON
        return new Response($jsonDemandesAssurance, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes/demandes-assurance", name="show_demandes_assurance")
     */
    public function demandesShow() : Response
    {
        return $this->render('/back_end/assurance/demandes/show_demandes.html.twig');
    }

    /**
     * @Route("/edit/demande-assurance-{id}", name="edit_demandes_assurance", options={"expose" = true})
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

            return $this->redirectToRoute('show_demandes_carte_tourisme');
        }

        return $this->render('/back_end/assurance/demandes/edit_demandes.html.twig', [
            'form'      => $form->createView(),
            'demande'   => $demande
        ]);
    }

    /**
     * @Route("/edit/voyageur-{id}", name="edit_voyageur_assurance", options={"expose"=true})
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
        return $this->render('/back_end/assurance/demandes/edit_voyageurs.html.twig', [
            'form'      => $form->createView(),
            'id'        => $voyageur->getId()
        ]);
    }
    

}