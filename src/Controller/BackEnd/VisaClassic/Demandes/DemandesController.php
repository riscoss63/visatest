<?php

namespace App\Controller\BackEnd\VisaClassic\Demandes;

use App\Entity\Course;
use App\Entity\Demande;
use App\Entity\EtatDossier;
use App\Entity\ReceptionDossier;
use App\Entity\User;
use App\Entity\VisaType;
use App\Form\Backend\VisaClassic\CompletReceptionType;
use App\Form\Backend\VisaClassic\DemandeType;
use App\Form\Backend\VisaClassic\EtatDossierType;
use App\Form\Backend\VisaClassic\IncompletReceptionType;
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
        $demandesVisaClassic = [];
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande')
            {
                $visaClassic = $demande->getVisaType()->getVisaClassic();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }
        $encoder = new JsonEncoder();
       
        
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesVisaClassic=$serializer->serialize($demandesVisaClassic, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES =>['id', 'client' => ['email'], 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic' => ['pays' => ['titre']]], 'dateCreation' => ['timestamp']],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes/demandes-visa-classic", name="show_demandes_visa_classic")
     */
    public function demandesShow() : Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        $courseVisa = 0;
        if($courses) 
        {
            foreach ($courses as $course) 
            {
                
                if($course->getDemande()->getVisaType() != null)
                {
                    $typeVisa = $course->getDemande()->getVisaType();
                    if($typeVisa->getVisaClassic())
                    {
                        $courseVisa += 1;
                    }
                }

                $courseVisa;
            }
        }
        
        return $this->render('/back_end/visa_classic/demandes/show_demandes.html.twig', [
            'nbDeCourse'    => $courseVisa
        ]);
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
            $visaClassic = $demande->getVisaType()->getVisaClassic();
            $receptionDossier = $demande->getReceptionDossier();

            if($visaClassic AND $receptionDossier AND $demande->getEtat() === 'reception')
            {
                $ReceptionDossierVisaClassic[] = $receptionDossier;
            }

            $ReceptionDossierVisaClassic;
        }

        $encoder = new JsonEncoder();
        // $defaultContext = [
        //     AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
        //         return $object->getTitre();
        //     },
        // ];
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonReceptionDossierVisaClassic=$serializer->serialize($ReceptionDossierVisaClassic, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES =>['id', 'demande', 'demande' => ['client' => ['email'], 'reference', 'visaType' => ['visaClassic' => ['pays' => ['titre']]], 'quantiteVisa', 'dateCreation' => ['timestamp'] ] ],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonReceptionDossierVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/reception-dossier", name="liste_reception_dossier")
     */
    public function receptionDossierShow(Request $request, EntityManagerInterface $manager) : Response
    {    
        $referenceType=$request->request->get('reference');
        if(isset($referenceType))
        {
            $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
                'reference'     => $referenceType
            ]);

            if($demande)
            {
                $receptionDossier = new ReceptionDossier;
                $receptionDossier->setIncomplet(true);
                $demande->setEtat('reception');
                $receptionDossier->setDemande($demande);
                $manager->persist($receptionDossier);
                $manager->flush();

                $this->addFlash('success', 'Demande ajouter');
                return $this->redirectToRoute('show_demandes_visa_classic');
            }

            elseif($demande === null AND $referenceType)
            {
                $this->addFlash('danger', 'La réference n\'existe pas');
                return $this->redirectToRoute('show_demandes_visa_classic');
            }
        }
        return $this->render('/back_end/visa_classic/demandes/show_reception_dossier.html.twig');
    }

    /**
     * @Route("/incomplet-dossier-{id}/visa-classic", name="incomplet_visa_classic", options={"expose" = true})
     */
    public function incompletDossierVisaClassic($id, Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer) : Response
    {
        $receptionDossier = $this->getDoctrine()->getRepository(ReceptionDossier::class)->find($id);
        $client = $receptionDossier->getDemande()->getClient();
        $form = $this->createForm(IncompletReceptionType::class, $receptionDossier);
        $form->handleRequest($request);
        

        if($form->isSubmitted() AND $form->isValid())
        {
            $etatDossiers = $receptionDossier->getEtatDossier();
            foreach ($etatDossiers as $etatDossier) 
            {
                if($etatDossier->getManquant() == false AND $etatDossier->getNonConforme() == false)
                {
                    $receptionDossier->removeEtatDossier($etatDossier);
                    $manager->remove($etatDossier);
                }
            }
            $manager->persist($receptionDossier);
            $manager->flush();

            $message= (new \Swift_Message('Document manquant : visa en ligne'))
                ->setFrom('sghairipro63@gmail.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView(
                        'back_end/emails/reception_dossier/incomplet_dossier.html.twig',
                        [
                            'client'        => $client,
                            'doccuments'   => $etatDossiers,
                            'receptionDossier'=>$receptionDossier
                        ]
                    ),
                    'text/html'
            );
            $mailer->send($message);

            $this->addFlash('success', 'Mail envoyer avec les doccuments manquant ou non conforme');
            return $this->redirectToRoute('show_demandes_visa_classic');
            
        }

        return $this->render('/back_end/visa_classic/demandes/incomplet_reception_dossier.html.twig', [
            'form'      => $form->createView(),
            'id'        => $receptionDossier->getId()
        ]);
    }

    /**
     * @Route("/complet-dossier-{id}/visa-classic", name="complet_dossier_visa_classic", options={"expose" = true})
     */
    public function completDossierVisaClassic($id, Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer) : Response
    {
        $receptionDossier = $this->getDoctrine()->getRepository(ReceptionDossier::class)->find($id);
        $demande = $receptionDossier->getDemande();
        $form= $this->createForm(CompletReceptionType::class, $receptionDossier);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $demande->setEtat('encours');
            
            $transport = $demande->getTransport();
            if($transport->getCoursier() == true)
            {
                $client = $demande->getClient();
                $random = random_int(10, 15);
                $reference = random_bytes($random);
                $reference=bin2hex($reference);
                //coursier par défaut
                $coursier = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                    'roles'     => '%ROLE_COURSIER%'
                ]);
                $course = new Course;
                $course->setNom($demande->getClient()->getNom());
                $course->setPrenom($demande->getClient()->getPrenom());
                $course->setAdresse($demande->getClient()->getAdresse());
                $course->setCodePostal($demande->getClient()->getCodepostal());
                $course->setVille($demande->getClient()->getVille());
                $course->setRealiser(false);
                $course->setCoursier($coursier);
                $course->setLivraison(true);
                $course->setDemande($demande);
                $course->setReference($reference);
                $manager->persist($course);
            }
            
            $manager->persist($receptionDossier);
            $manager->flush();
            $client = $demande->getClient();

            $message= (new \Swift_Message('Doccuments reçu : visa en ligne'))
                ->setFrom('sghairipro63@gmail.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->renderView(
                        'back_end/emails/reception_dossier/dossier_reçu.html.twig',
                        [
                            'client'        => $client,
                            'receptionDossier'  =>$receptionDossier
                        ]
                    ),
                    'text/html'
            );
            $mailer->send($message);

            $this->addFlash('success', 'Dossier valider');

            return $this->redirectToRoute('show_demandes_visa_classic');
        }

        return $this->render('/back_end/visa_classic/demandes/complet_reception_dossier.html.twig', [
            'form'      => $form->createView(),
            'id'        => $receptionDossier->getId()
        ]);
    }

    /**
     *@Route("/json/demande-dossier-non-recu", name="json_dossier_non_recu") 
     */
    public function jsonDossierNonRecu()
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $demandesVisaClassic = [];
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande' AND $demande->getReceptionDossier() == null)
            {
                $visaClassic = $demande->getVisaType()->getVisaClassic();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }
        $encoder = new JsonEncoder();

        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesVisaClassic=$serializer->serialize($demandesVisaClassic, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES =>['id', 'client' => ['email'], 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic' => ['pays' => ['titre']]], 'dateCreation' => ['timestamp']],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }


    /**
     * @Route("/liste/demande-dossier-non-recu", name="rappel_dossier_non_recu", options={"expose"=true})
     */
    public function dossierNonRecu(Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer)
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $demandesVisaClassic = [];
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande' AND $demande->getReceptionDossier() == null)
            {
                $visaClassic = $demande->getVisaType()->getVisaClassic();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }

        if($request->get('choices'))
        {
            $idDemandesSend = $request->get('choices');
            foreach($idDemandesSend as $idDemande)
            {
                $demandeSend = $this->getDoctrine()->getRepository(Demande::class)->find($idDemande);
                $client = $demandeSend->getClient();
                $message= (new \Swift_Message('Dossier non reçu : visa en ligne'))
                    ->setFrom('sghairipro63@gmail.com')
                    ->setTo($client->getEmail())
                    ->setBody(
                        $this->renderView(
                            'back_end/emails/demande_visa_classic/rappel_demande.html.twig',
                            [
                                'client'        => $client,
                                'demande'       => $demande
                            ]
                        ),
                        'text/html'
                );
                $mailer->send($message);
            }

            $this->addFlash('success', 'Mail envoyer');
            return $this->redirectToRoute('liste_reception_dossier');
        }
        


        return $this->render('/back_end/visa_classic/demandes/rappel_dossier.html.twig', [
            'demandes'      => $demandesVisaClassic
        ]);
    }


}