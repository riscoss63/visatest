<?php

namespace App\Controller\BackEnd\Assurances\Demandes;

use App\Entity\Assurance;
use App\Entity\AttestationAssurance;
use App\Entity\Course;
use App\Entity\Demande;
use App\Entity\EtatDossier;
use App\Entity\ReceptionDossier;
use App\Entity\Voyageurs;
use App\Form\Backend\Assurance\AssuranceType;
use App\Form\Backend\Assurance\AttestationType;
use App\Form\Backend\VisaClassic\CompletReceptionType;
use App\Form\Backend\VisaClassic\DemandeType;
use App\Form\Backend\VisaClassic\EtatDossierType;
use App\Form\Backend\VisaClassic\IncompletReceptionType;
use App\Form\Backend\VisaClassic\VoyageursType;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Attachment;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * @Route("/gestion/demandes/assurance")
 */
class DemandesController extends AbstractController
{
    /**
     * @Route("/liste/json-demandes-{etat}", name="json_demandes_assurance")
     */
    public function demandesJson($etat) : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            if($etat === 'commande')
            {
                $etatSend = 'commande';
            }
            else
            {
                $etatSend = 'terminer';
            }
             
            if($demande->getEtat() === $etatSend)
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

    /**
     * @Route("/send/assurance-{id}", name="send_assurance", options={"expose"=true})
     */
    public function assuranceSend(Request $request, $id, EntityManagerInterface $manager, \Swift_Mailer $mailer, UploaderHelper $helper, UrlHelper $urlHelper)
    {
        $voyageur = $this->getDoctrine()->getRepository(Voyageurs::class)->find($id);
        $client = $voyageur->getDemande()->getClient();
        $attestation = new AttestationAssurance;
        $form = $this->createForm(AttestationType::class, $attestation);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $voyageur->setAttestation($attestation);
            $voyageur->getDemande()->setEtat("terminer");
            $manager->persist($voyageur);
            $manager->flush();


            $this->addFlash('success', 'Attestation envoyer');
            $attestationAssurance = $urlHelper->getAbsoluteUrl($helper->asset($attestation, 'imageFile'));

            $message= (new \Swift_Message('Attestation assurance'))
                ->setFrom('sghairipro63@gmail.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView(
                        'back_end/emails/attestation_assurance.html.twig',
                        [
                            'voyageur'   => $voyageur,
                            'client'        => $client,
                        ]
                    ),
                    'text/html'
                )
                ->attach(Swift_Attachment::fromPath($attestationAssurance))
            ;
            $mailer->send($message);
            return $this->redirectToRoute('show_demandes_assurance');
        }

        return $this->render('/back_end/assurance/demandes/send_attestation.html.twig', [
            'form'          => $form->createView(),
            'id'            => $voyageur->getId()
        ]);
        
    }

    /**
     * @Route("/listes/archives", name="archives_demandes_assurance")
     */
    public function archivesListe() : Response
    {
        return $this->render('/back_end/assurance/demandes/show_archives.html.twig');
    }
    

}