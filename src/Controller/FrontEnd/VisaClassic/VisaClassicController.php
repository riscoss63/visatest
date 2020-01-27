<?php

namespace App\Controller\FrontEnd\VisaClassic;

use App\Entity\Continent;
use App\Entity\Demande;
use App\Entity\VisaClassic;
use App\Entity\VisaType;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('/front_end/visa_classic/visa_classic_show.html.twig', [
            'visa'      => $visaClassic,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
            'assurances'                => $assurances
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
     * @Route("/commande/type-{id}", name="paiement_visa_classic")
     */
    public function visaClassicPaiement(Request $request, EntityManagerInterface $manager): Response
    {
        $commande = new Demande();
        
        $nbvoyageurs = $request->get('nbvoyageurs');
        $nationalites = $request->get('country');
        $dateEntree = $request->get('date_entree');
        $dateSortie = $request->get('date_sortie');
        $dureeSejour = $request->get('order-duration');
        $paysLivraison = $request->get('countrylivraison');
        $codepostalVille = $request->get('postalVille');
        $transport = $request->get('mode-livraison');
        $enlevement = $request->get('radio');
        $email = $request->get('email');
        $nbassurance = $request->get('nbassurance');
        $assurance = $request->get('assurance');

    }
}