<?php

namespace App\Controller\FrontEnd\VisaClassic;

use App\Entity\AdresseFacturation;
use App\Entity\Assurance;
use App\Entity\Continent;
use App\Entity\Demande;
use App\Entity\ModeExpedition;
use App\Entity\NotreService;
use App\Entity\Transport;
use App\Entity\User;
use App\Entity\VisaClassic;
use App\Entity\VisaType;
use App\Entity\Voyageurs;
use App\Repository\TransportRepository;
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
use Symfony\Component\Validator\Constraints\Date;

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
                'assurances'     => $assurances
            ]);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/commande/visa-{id}", name="enregistrer_commande_visa_classic")
     */
    public function visaClassicPaiement(Request $request, EntityManagerInterface $manager, $id, SessionInterface $session, UserPasswordEncoderInterface $encoder)
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


        //On récupe si une vérification est à faire
        $verif = $request->get('verif');

        //On récupe la session de user
        $userSession = $this->getUser();


        //Vérification profil
        if($verif === 'profil')
        {

            //Si l'adresse de livraison/facturation est differente
            if($diffFacturation)
            {
                $facturation = new AdresseFacturation;
                $facturation->setAdresse($adresseFacturation);
                $facturation->setCodePostal($codePostalFacturation);
                $facturation->setVille($villeFacturation);
                $facturation->setTelephone($telephoneFacturation);
                $userSession->setAdresseFacturation($facturation);
            }

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
                if($userSession->getId() === $user->getId() ) {
                    return new JsonResponse(array(
                        'status' => 'success',
                        'message' => 'Veuillez poursuivre votre commande'),
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

            return new Response(json_encode(array('status'=>'success'))); 
        }
        

    }
}