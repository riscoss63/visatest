<?php

namespace App\Controller\FrontEnd\VisaClassic;

use App\Entity\AdresseFacturation;
use App\Entity\Assurance;
use App\Entity\Continent;
use App\Entity\Demande;
use App\Entity\Frais;
use App\Entity\InfosEntreprise;
use App\Entity\ModeExpedition;
use App\Entity\NotreService;
use App\Entity\Transport;
use App\Entity\User;
use App\Entity\VisaClassic;
use App\Entity\VisaType;
use App\Entity\Voyageurs;
use App\Repository\TransportRepository;
use App\Service\BonDeCommandeService;
use App\Service\MoneticoPaiement;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Knp\Snappy\Pdf;

/**
 * @Route("/visa-classic")
 */
class VisaClassicController extends AbstractController
{
    private $transports;

    public function __construct(TransportRepository $transport)
    {
        $this->transports = $transport->findVisaClassic();
    }

    /**
     * @Route("/visa-{slug}", name="visa_classic_show")
     */
    public function visaShow($slug) : Response
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

        $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->findOneBy([
            'slug'      => $slug
        ]);
        $assurances = $visaClassic->getPays()->getAssurances();

        $modeExpedition = $this->getDoctrine()->getRepository(ModeExpedition::class)->findOneBy([
            'visaClassic'       => true,
        ]);

        $notreService = $this->getDoctrine()->getRepository(NotreService::class)->findOneBy([
            'visaClassic'       => true,
        ]);

        return $this->render('/front_end/visa_classic/visa_classic_show.html.twig', [
            'visa'                      => $visaClassic,
            'continentsVisaClassic'     => $visasClassics,
            'continentsEvisa'           => $eVisas,
            'assurances'                => $assurances,
            'voletModeExpedition'            => $modeExpedition,
            'notreService'              => $notreService
        ]);
    }

    /**
     * @Route("/commande", name="commande_visa_classic")
     */
    public function visaClassicCommande(Request $request) : Response
    {
        $id=$request->get('typevisa');
        if($id)
        {
            $typeVisa = $this->getDoctrine()->getRepository(VisaType::class)->find($id);
            $assurances = $typeVisa->getVisaClassic()->getPays()->getAssurances();
            return $this->render('front_end/visa_classic/visa_classic_commande.html.twig', [
                'typeVisa'      => $typeVisa,
                'transports'     => $this->transports,
                'assurances'     => $assurances,
                'rappel'        => null
            ]);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/commande/visa-{id}", name="enregistrer_commande_visa_classic")
     */
    public function visaClassicPaiement(Request $request, EntityManagerInterface $manager, $id, SessionInterface $session, UserPasswordEncoderInterface $encoder, MoneticoPaiement $monetico, BonDeCommandeService $bonDeCommandeService)
    {
        //Variable avec la date d'aujourd'hui
        $aujourdhui = new \DateTime('now');

        //On récupere le type de visa et on crée une commande
        $typeVisa = $this->getDoctrine()->getRepository(VisaType::class)->find($id);
        $commande = new Demande();
        
        
        //On récupe le nb de visiteurs ainsi que leur nationalités
        $nbvoyageurs = $request->get('nbvoyageurs');
        $nationalites = $request->get('country');

        //Date d'entré et de sortie
        $dateEntree = $request->get('date_entree');
        $dateSortie = $request->get('date_sortie');
        $dateEntreeFormat = \DateTime::createFromFormat('d/m/Y', $dateEntree);
        $dateSortieFormat = \DateTime::createFromFormat('d/m/Y', $dateSortie);

        //durée du séjour ainsi que la livraison
        $dureeSejour = $request->get('order-duration');
        $paysLivraison = $request->get('countrylivraison');
        $codepostalVille = $request->get('postalVille');

        //le type de transport ainsi que le numéro de vol
        $transportId = $request->get('mode-livraison');
        $numVol = $request->get('numero-vol');
        $jourVol = $request->get('jour-vol');

        //On récupe l'email et le type d'enlevement
        $enlevement = $request->get('radio_enlevement');
        $email = $request->get('email');

        //a garder pour plus tard dans le développement
        $nbassurance = $request->get('nbassurance');
        $assuranceId = $request->get('assurance');
        
        //On récupe les données du profil livraison
        $nom = $request->get('nom');
        $prenom = $request->get('prenom');
        $adresseLivraison = $request->get('adresse');
        $codePostalLivraison = $request->get('codePostal');
        $villeLivraison = $request->get('ville');
        $telephoneLivraison = $request->get('telephone');

        //Si c'est true l'adresse de facturation est differente
        $diffFacturation = $request->get('address-facturation');
        $adresseFacturation = $request->get('adresseFacturation');
        $codePostalFacturation = $request->get('codePostalFacturation');
        $villeFacturation = $request->get('villeFacturation');
        $telephoneFacturation = $request->get('telephoneFacturation');
        
        //On récupere le mode de paiement
        $paiement = $request->get('paiement');

        //On récupe si une vérification est à faire
        $verif = $request->get('verif');

        //On récupe la session de user
        $userSession = $this->getUser();

        //Récuperer une commande avec l'étape non finaliser
        $commandeNonFinaliser = $request->get('nonFinaliser');
        if($commandeNonFinaliser)
        {
            $assurances = $typeVisa->getVisaClassic()->getPays()->getAssurances();
            $rappel = $this->getDoctrine()->getRepository(Demande::class)->find($commandeNonFinaliser);
            return $this->render('front_end/visa_classic/visa_classic_commande.html.twig', [
                'typeVisa'      => $typeVisa,
                'transports'     => $this->transports,
                'assurances'     => $assurances,
                'rappel'        => $rappel
            ]);
        }
        

        //Vérification profil
        if($verif === 'profil')
        {
            $demande = $this->getDoctrine()->getRepository(Demande::class)->find($session->get('demande'));
            $frais = new Frais;
            $demande->setFrais($frais);
            if($nom AND $prenom AND $adresseLivraison AND $codePostalLivraison AND $villeLivraison)
            {
                //Calcule du total de la commande{{typeVisa.fraisConsulaire + typeVisa.fraisEdition + typeVisa.fraisFormulaire}}
                $typeVisa = $demande->getVisaType();
                $enlevement = $demande->getEnlevement();
                $livraison = $demande->getTransport();
                $prixVisa = $typeVisa->getFraisConsulaire() + $typeVisa->getFraisEdition() + $typeVisa->getFraisFormulaire();
                $prixEnlevement = 0;
                $prixLivraison = $livraison->getTarif();
                if($enlevement)
                {
                    $prixEnlevement = $enlevement->getTarif();
                }
                $prixTotalVisa = $prixVisa * $demande->getQuantiteVisa();
                $total = $prixTotalVisa + $prixEnlevement + $prixLivraison;
                $demande->setTotal($total);


                //On met a jour les frais pour être modifier en back end
                $frais->setFraisConsulaire($typeVisa->getFraisConsulaire());
                $frais->setQuantiteConsulaire($demande->getQuantiteVisa());

                $frais->setFraisEdition($typeVisa->getFraisEdition());
                $frais->setQuantiteEdition($demande->getQuantiteVisa());

                $frais->setFraisLivraison($prixLivraison);
                $frais->setQuantiteLivraison(1);

                $frais->setFraisEnlevement($prixEnlevement);
                $frais->setQuantiteEnlevement(1);

                if($typeVisa->getFraisFormulaireValide() === true)
                {
                    $frais->setFraisFormulaire($typeVisa->getFraisFormulaire());
                    $frais->setQuantiteFormulaire($demande->getQuantiteVisa());
                }
                $frais->setTotal($total);
                



                $userSession->setNom($nom);
                $userSession->setPrenom($prenom);
                $userSession->setAdresse($adresseLivraison);
                $userSession->setCodePostal($codePostalLivraison);
                $userSession->setVille($villeLivraison);
                // $userSession->setTelephone($telephoneLivraison);

                //Si l'adresse de livraison/facturation est differente
                if($diffFacturation === 'on')
                {
                    $facturation = new AdresseFacturation;
                    $facturation->setAdresse($adresseFacturation);
                    $facturation->setCodePostal($codePostalFacturation);
                    $facturation->setVille($villeFacturation);
                    // $facturation->setTelephone($telephoneFacturation);
                    $userSession->setAdresseFacturation($facturation);
                }
                else 
                {
                    $facturation = new AdresseFacturation;
                    $facturation->setAdresse($adresseLivraison);
                    $facturation->setCodePostal($codePostalLivraison);
                    $facturation->setVille($villeLivraison);
                    // $facturation->setTelephone($telephoneLivraison);
                    $userSession->setAdresseFacturation($facturation);
                }

                $date = new \DateTime('now');
                $demande->setMoneticoDate($date->format('d/m/Y:H:i:s'));
                $manager->persist($demande);
                $reference = $demande->getReference();
                $manager->persist($userSession);
                $manager->flush();

                $form=$monetico->genererFormData($demande);
                $action = $monetico->getFormAction();
                return new JsonResponse(array(
                    'status' => 'success',
                    'message' => 'Profil enregistrer',
                    'form'    => json_encode($form),
                    'action'    => json_encode($action)),
                200);
            }
            

            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Veuillez remplir tous les champs'),
            400);
            

        }



        //Vérification date d'entrée et de sortie
        if($verif === 'date_entree')
        {
            //On formate la date d'aujourd'hui
            $aujourdhuiFormatter = \DateTime::createFromFormat('d/m/Y', $aujourdhui->format('d/m/Y'));


            if($dateEntree AND $dateSortie)
            {
                if($dateEntreeFormat >= $aujourdhuiFormatter AND $dateSortieFormat >= $dateEntreeFormat)
                {
                    return new JsonResponse(array(
                        'status' => 'success',
                        'message' => 'Parfait ! '),
                    200);
                }
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'Veuillez rentrer une date d\'entre et de sortie supérrieur a aujourdhui'),
                400);
            }
            else
            {
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'Veuillez rentrer une date d\'entre et de sortie valide'),
                400);
            }
        }

        
        if($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'Format de mail invalide'),
                400);
            }
            //On génére la réference de la demande
            $random = random_int(3, 3);
            $reference = random_bytes($random);
            $reference=bin2hex($reference);
            
            //On modifie la reference et l'état de la commande
            $commande->setReference(strtoupper($reference.'VC'));
            $commande->setEtat('paiement');
            

            $commande->setVisaType($typeVisa);
            
            $commande->setQuantiteVisa($nbvoyageurs);
            
            $commande->setUrgent(false);


            
            if($dateEntreeFormat != null AND $dateSortieFormat != null) {
                //On formate la date et on l'ajoute
                
                $commande->setEntre(new \DateTime($dateEntreeFormat->format('Y/m/d')));
                $commande->setSortie(new \DateTime($dateSortieFormat->format('Y/m/d')));
                
            }
            else {
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'Veuillez rentrer une date d\'entre et de sortie'),
                400);
            }
            
            if($enlevement === 'coursier')
            {
                $transport = $this->getDoctrine()->getRepository(Transport::class)->findOneBy([
                    'coursier'      => true
                ]);
                $commande->setEnlevement($transport);
            }
            
            $transport = $this->getDoctrine()->getRepository(Transport::class)->find($transportId);
            if($transport->getAeroport() === true)
            {
                $jourVolFormat = \DateTime::createFromFormat('d/m/Y', $jourVol);
                $commande->setJourVol(new \DateTime($jourVolFormat->format('Y/m/d')));
                $commande->setNumeroVol($numVol);
            }
            
            $commande->setTransport($transport);

            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'email'     => $email
            ]);
            
            if($user) {
                $frais = new Frais;
                $commande->setFrais($frais);
                //Calcule du total de la commande{{typeVisa.fraisConsulaire + typeVisa.fraisEdition + typeVisa.fraisFormulaire}}
                $typeVisa = $commande->getVisaType();
                $enlevement = $commande->getEnlevement();
                $livraison = $commande->getTransport();
                $prixVisa = $typeVisa->getFraisConsulaire() + $typeVisa->getFraisEdition() + $typeVisa->getFraisFormulaire();
                $prixEnlevement = 0;
                $prixLivraison = $livraison->getTarif();
                if($enlevement)
                {
                    $prixEnlevement = $enlevement->getTarif();
                }
                $prixTotalVisa = $prixVisa * $commande->getQuantiteVisa();
                $total = $prixTotalVisa + $prixEnlevement + $prixLivraison;
                
                $commande->setTotal($total);

                //On met a jour les frais pour être modifier en back end
                $frais->setFraisConsulaire($typeVisa->getFraisConsulaire());
                $frais->setQuantiteConsulaire($commande->getQuantiteVisa());

                $frais->setFraisEdition($typeVisa->getFraisEdition());
                $frais->setQuantiteEdition($commande->getQuantiteVisa());

                $frais->setFraisLivraison($prixLivraison);
                $frais->setQuantiteLivraison(1);

                $frais->setFraisEnlevement($prixEnlevement);
                $frais->setQuantiteEnlevement(1);



                if($userSession->getId() === $user->getId() ) 
                {
                    $commande->setClient($user);
                    
                    $manager->persist($commande);
                    $manager->flush();

                    $session->set('demande', $commande->getId());

                    
                    return new JsonResponse(array(
                        'status' => 'success',
                        'message' => 'Veuillez poursuivre votre commande',
                        'demande' => $commande->getId()),
                    200);
                }
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => "Mail déja existant, Veuillez vous connecter ou choisir une autre adresse mail"),
                400);
            }
            
            $newUser = new User;
            $newUser->setEmail($email);
            //On crée un mdp aleatoire
            $random = random_int(5, 10);
            $password = random_bytes($random);
            //encode grâce a l'encodage auto
            $newUser->setPassword($encoder->encodePassword($newUser, bin2hex($password)));
            $commande->setClient($newUser);

            // for ($i=0; $i < $nbvoyageurs ; $i++) 
            // { 
            //     $voyageur = new Voyageurs;
            //     // $voyageur->setNationalite()

            // }

            $manager->persist($commande);
            $manager->flush();
            
            

            //On insere la demande dans une session
            $session->set('demande', $commande->getId());


            //Connexion auto
            //On stock les données dans le token
            $token=new UsernamePasswordToken(
                $newUser,
                $newUser->getPassword(),
                'main',
                $newUser->getRoles()
            );

            //On modifie le token pour être connecter
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return new JsonResponse(array(
                'status' => 'success',
                'message' => 'Veuillez poursuivre votre commande',
                'demande' => $commande->getId()),
            200);
        }     

    }

    /**
     * @Route("/demande/rappel-{id}", name="rappel_demande_visa_classic", options={"expose"=true})
     */
    public function rappelDemande($id, BonDeCommandeService $bonDeCommandeService)
    {
        $commande = $this->getDoctrine()->getRepository(Demande::class)->find($id);

        //On genere le bon de commande et on le send
        $infosEntreprise = $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy([
            'typeVisa'  => 'visa_classic'
        ]);
        $template = '/front_end/emails/visa_classic/demande/formulaire_non_finaliser.html.twig';
        $vars = [
            'demande'   => $commande,
            'client'    => $commande->getClient(),
            'entreprise'    => $infosEntreprise
        ];
        $bonDeCommandeService->generateur($commande, $template, $vars);

        return new JsonResponse(array(
            'status' => 'success'),
        200);
    }
}