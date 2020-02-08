<?php

namespace App\Controller\BackEnd\VisaClassic\Demandes;

use App\Entity\Demande;
use App\Entity\Expedition;
use App\Entity\FraisComplementaire;
use App\Form\Backend\VisaClassic\DemandeFraisType;
use App\Form\Backend\VisaClassic\ExpeditionType;
use App\Form\Backend\VisaClassic\FraisComplementaireType;
use App\Form\Backend\VisaClassic\NouvelleDemandeType;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Error\RuntimeError;

/**
 * @Route("/gestion/demandes-en-cours")
 */
class DemandesEnCoursController extends AbstractController
{
    /**
     * @Route("/liste/json-demandes", name="json_demandes_en_cours_visa_classic")
     */
    public function demandesJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $demandesVisaClassic = [];
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'encours' AND $demande->getReceptionDossier())
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
            AbstractNormalizer::ATTRIBUTES =>['id', 'client' => ['email'], 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic' => ['pays' => ['titre']]], 'dateCreation' => ['timestamp'], 'receptionDossier'=>['depot', 'dossierRecu' => ['timestamp']]],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }


    /**
     * @Route("/liste/demande-visa-classic", name="show_demande_en_cours_visa_classic")
     */
    public function demandeEnCoursShow() :Response
    {
        return $this->render('/back_end/visa_classic/demandes/show_demandes_en_cours.html.twig');
    }

    /**
     * @Route("/frais-complementaire-{id}/visa-classic", name="frais_completementaire_visa_classic", options={"expose"=true})
     */
    public function fraisComplementaireEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $demande= $this->getDoctrine()->getRepository(Demande::class)->find($id);

        $form = $this->createForm(DemandeFraisType::class, $demande);
    
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $fraisComplementaires = $form->get('fraisComplementaire')->getData();
            foreach ($fraisComplementaires as $frais) 
            {
                $total = $frais->getQuantite() * $frais->getPrixUnitaire();
                $frais->setTotal($total);
            }

            $manager->persist($demande);
            $manager->flush();

            return $this->redirectToRoute('show_demande_en_cours_visa_classic');
        }
        return $this->render('/back_end/visa_classic/demandes/encours/edit_frais_complementaire.html.twig', [
            'form'      => $form->createView(),
            'id'        => $demande->getId()
        ]);
    }

    /**
     * @Route("/liste/json-expedition", name="json_expedition_visa_classic")
     */
    public function receptionDossierJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $expeditionVisaClassic = [];
        foreach($demandes as $demande)
        {
            $visaClassic = $demande->getVisaType()->getVisaClassic();
            $expedition = $demande->getExpedition();

            if($visaClassic AND $expedition AND $expedition->getDemande()->getTransport()->getCoursier() === false)
            {
                $expeditionVisaClassic[] = $expedition;
            }

            $expeditionVisaClassic;
        }

        $encoder = new JsonEncoder();
        
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonExpeditionVisaClassic=$serializer->serialize($expeditionVisaClassic, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES =>['id', 'suivi', 'demande' => ['reference', 'client' => ['email'], 'quantiteVisa', 'transport' => ['titre'], ], ],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonExpeditionVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/expeditions/visa-classic", name="expedition_visa_classic", options={"expose"=true})
     */
    public function expeditionsShow(Request $request, EntityManagerInterface $manager) : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $expeditionVisaClassic = [];
        foreach($demandes as $demande)
        {
            $visaClassic = $demande->getVisaType()->getVisaClassic();
            $expedition = $demande->getExpedition();

            if($visaClassic AND $expedition AND $expedition->getDemande()->getTransport()->getCoursier() === false AND $expedition->getDemande()->getEtat() === 'encours')
            {
                $expeditionVisaClassic[] = $expedition;
            }

            $expeditionVisaClassic;
        }

        $formAjout = $this->createFormBuilder()
            ->add('reference', TextType::class, [
                'attr'      => [
                    'placeholder'   => '  reference de la demande',
                    'class' => 'form-control'
                ]
                
            ])
            
            ->getForm()
        ;
        
        $formAjout->handleRequest($request);

        if($formAjout->isSubmitted() AND $formAjout->isValid())
        {

            $referenceType=$formAjout->getData('reference');
            $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
                'reference'     => $referenceType
            ]);

            if($demande AND !$demande->getExpedition())
            {
                $expedition = new Expedition;

                $expedition->setDemande($demande);
                $manager->persist($expedition);
                $manager->flush();
                
                return new Response(json_encode(array('status'=>'success')));
            }
            else
            {
                $formAjout->addError(new FormError('demande inexistante'));

                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'Error'),
                400);
            }
        }

        return $this->render('/back_end/visa_classic/demandes/encours/edit_expedition.html.twig', [
            'formAjout'     => $formAjout->createView(),
            'expeditions'   =>$expeditionVisaClassic
        ]);
    }

    /**
     * @Route("/suivi/expedition", name="suivi_expedition_visa_classic", options={"expose"=true})
     */
    public function expeditionEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $id=$request->get('id');
        $suivi = $request->get('suivi');
        if($id AND $suivi)
        {
            $expedition = $this->getDoctrine()->getRepository(Expedition::class)->find($id);
            if($expedition)
            {
                $suivi = $request->request->get('suivi');
                $expedition->setSuivi($suivi);
                $demande = $expedition->getDemande();
                $demande->setEtat('archive');
                $manager->persist($expedition);
                $manager->flush();

                return new Response(json_encode(array('status'=>'success')));
            }

            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Error'),
            400);
        }
        return new JsonResponse(array(
            'status' => 'Error',
            'message' => 'Error'),
        400);
    }

    /**
     * @Route("/nouvelle-commande", name="add_commande_visa_classic")
     */
    public function commandeAdd(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {
        $demande = new Demande;
        
        $form = $this->createForm(NouvelleDemandeType::class, $demande);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            //Si faut crée le client
            $userAdd=$form->get('clientInscription')->getData();
            if($userAdd->getEmail() !== null)
            {
                    //On crée un mdp aleatoire
                $random = random_int(10, 15);
                $password = random_bytes($random);
                //encode grâce a l'encodage auto
                $userAdd->setPassword($encoder->encodePassword($userAdd, bin2hex($password)));

                $userAdd->setDateCreation(new \DateTime("now"));
                $demande->setClient($userAdd);
                $manager->persist($userAdd);
                $manager->flush();

                //Envoie de mail inscription
                $message= (new \Swift_Message('Inscription visa en ligne'))
                    ->setFrom('sghairipro63@gmail.com')
                    ->setTo($userAdd->getEmail())
                    ->setBody(
                        $this->renderView(
                            'front_end/emails/inscription.html.twig',
                            [
                                'mdp'   => bin2hex($password),
                                'client'        => $userAdd
                            ]
                        ),
                        'text/html'
                );
                $mailer->send($message);
            }
            
            //Si frais complementaires
            $fraisComplementaires = $form->get('fraisComplementaire')->getData();
            if(isset($fraisComplementaires))
            {
                foreach ($fraisComplementaires as $frais) 
                {
                    $total = $frais->getQuantite() * $frais->getPrixUnitaire();
                    $frais->setTotal($total);
                }
            }
            
            //On génére la réference de la demande
            $random = random_int(10, 15);
            $reference = random_bytes($random);
            $reference=bin2hex($reference);
            //On modifie la reference et l'état
            $demande->setReference($reference);
            $demande->setEtat('commande');
            
            //On entre le nb de visa
            $voyageurs = $demande->getVoyageurs();
            $nbVisa = count($voyageurs);
            $demande->setQuantiteVisa($nbVisa);
            $manager->persist($demande);
            $manager->flush();

            $this->addFlash('success', 'Demande ajouter');
            return $this->redirectToRoute('show_demande_en_cours_visa_classic');
        }

        return $this->render('/back_end/visa_classic/demandes/encours/nouvelle_commande.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/json/remise-main-propre", name="json_livraison_agence")
     */
    public function livraisonAgenceJson()
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $livraisonAgence = [];
        foreach($demandes as $demande)
        {
            $visaClassic = $demande->getVisaType()->getVisaClassic();

            if($visaClassic AND $demande->getTransport()->getAgence() === true AND $demande->getEtat() === 'encours')
            {
                $livraisonAgence[] = $demande;
            }

            $livraisonAgence;
        }

        $encoder = new JsonEncoder();
        
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonLivraisonAgence=$serializer->serialize($livraisonAgence, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES =>['id', 'reference', 'client' => ['email'], 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic' => ['pays' => ['titre']]], 'dateCreation' => ['timestamp']],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonLivraisonAgence, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/remise-main-propre", name="liste_livraison_agence", options={"expose"=true})
     */
    public function listeLivraisonAgence(Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer)
    {
        $id = $request->get('id');
        if($id)
        {
            $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
            if($demande)
            {
                $demande->setEtat('archive');
                $client = $demande->getClient();
                //Envoie de mail inscription
                $message= (new \Swift_Message('Mise à disposition visa en agence : visa en ligne'))
                    ->setFrom('sghairipro63@gmail.com')
                    ->setTo($client->getEmail())
                    ->setBody(
                        $this->renderView(
                            'back_end/emails/livraison_agence.html.twig',
                            [
                                'client'   => $client,
                                'demande'        => $demande
                            ]
                        ),
                        'text/html'
                );
                $mailer->send($message);
                $manager->persist($demande);
                $manager->flush();
            }
        }
        return $this->render('/back_end/visa_classic/demandes/encours/livraison_agence.html.twig');
    }
}