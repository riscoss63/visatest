<?php

namespace App\Controller\BackEnd\VisaClassic\Demandes;

use App\Entity\Demande;
use App\Entity\ReceptionDossier;
use App\Form\Backend\VisaClassic\DemandeType;
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
 * @Route("/gestion/demandes")
 */
class DemandesController extends AbstractController
{
    /**
     * @Route("/liste/json-demandes", name="json_demandes_visa_classic")
     */
    public function demandesJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande')
            {
                $visaClassic = $demande->getVisaType();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesVisaClassic=$serializer->serialize($demandesVisaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes/demandes-visa-classic", name="show_demandes_visa_classic")
     */
    public function demandesShow() : Response
    {
        return $this->render('/back_end/visa_classic/demandes/show_demandes.html.twig');
    }

    /**
     * @Route("/edit/demande-visa-classic-{id}", name="edit_demandes_visa_classic", options={"expose" = true})
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

            return $this->redirectToRoute('show_demandes_visa_classic');
        }

        return $this->render('/back_end/visa_classic/demandes/edit_demandes.html.twig', [
            'form'      => $form->createView(),
            'demande'   => $demande
        ]);
    }

    /**
     * @Route("/liste/json-reception-dossier", name="json_reception_dossier_visa_classic")
     */
    public function receptionDossierJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            $visaClassic = $demande->getVisaType();
            $receptionDossier = $demande->getReceptionDossier();

            if($visaClassic AND $receptionDossier)
            {
                $ReceptionDossierVisaClassic[] = $receptionDossier;
            }

            $ReceptionDossierVisaClassic;
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonReceptionDossierVisaClassic=$serializer->serialize($ReceptionDossierVisaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonReceptionDossierVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/reception-dossier", name="liste_reception_dossier")
     */
    public function receptionDossierShow(Request $request, EntityManagerInterface $manager) : Response
    {    
        $referenceType=$request->request->get('reference');
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
            'reference'     => $referenceType
        ]);

        if($demande)
        {
            $receptionDossier = new ReceptionDossier;
            $receptionDossier->setIncomplet(true);
            $receptionDossier->setDemande($demande);
            $manager->persist($receptionDossier);
            $manager->flush();

            return $this->redirectToRoute('show_demandes_visa_classic');
        }
        elseif($demande === null AND $referenceType)
        {
            return $this->redirectToRoute('show_demandes_visa_classic');
        }
        
        return $this->render('/back_end/visa_classic/demandes/show_reception_dossier.html.twig');
    }

}