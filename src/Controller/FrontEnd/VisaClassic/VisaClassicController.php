<?php

namespace App\Controller\FrontEnd\VisaClassic;

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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $typeVisa = $this->getDoctrine()->getRepository(VisaType::class)->find($id);
        $commande = new Demande();
        
        
        $nbvoyageurs = $request->get('nbvoyageurs');
        $nationalites = $request->get('country');
        $dateEntree = $request->get('date_entree');
        $dateSortie = $request->get('date_sortie');
        $dureeSejour = $request->get('order-duration');
        $paysLivraison = $request->get('countrylivraison');
        $codepostalVille = $request->get('postalVille');
        $transportId = $request->get('mode-livraison');
        $numVol = $request->get('numero-vol');
        $jourVol = $request->get('jour-vol');
        $enlevement = $request->get('radio_enlevement');
        $email = $request->get('email');
        $nbassurance = $request->get('nbassurance');
        $assuranceId = $request->get('assurance');
            // //Si l'user a choisi une assurance
            // if($assuranceId != 'noassurance')
            // {
            //     $assurance = $this->getDoctrine()->getRepository(Assurance::class)->find($assuranceId);
            //     $commande->setAssurance($assurance);

            // }
            
            // tot
        if($request->isMethod('post'))
        {
            //On génére la réference de la demande
            $random = random_int(5, 10);
            $reference = random_bytes($random);
            $reference=bin2hex($reference);
            
            //On modifie la commande
            $commande->setReference($reference.'VC');

            $commande->setEtat('paiement');
            
            $commande->setVisaType($typeVisa);
            
            $commande->setQuantiteVisa($nbvoyageurs);
            
            $commande->setUrgent(false);

            $dateEntreeFormat = \DateTime::createFromFormat('d/m/Y', $dateEntree);
            $dateSortieFormat = \DateTime::createFromFormat('d/m/Y', $dateSortie);
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
                $session->set('commande', $commande);
                return new JsonResponse(array(
                    'status' => 'Error',
                    'message' => 'Mail déja existant, Veuillez vous connecter ou choisir une autre adresse mail'.$this->generateUrl('app_login')),
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
            return new Response(json_encode(array('status'=>'success')));

            
            
        }


    }
}