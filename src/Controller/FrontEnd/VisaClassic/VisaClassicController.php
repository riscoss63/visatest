<?php

namespace App\Controller\FrontEnd\VisaClassic;

use App\Entity\Continent;
use App\Entity\VisaClassic;
use App\Entity\VisaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/visa-classic")
 */
class VisaClassicController extends AbstractController
{
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

        return $this->render('/front_end/visa_classic/visa_classic_show.html.twig', [
            'visa'      => $visaClassic,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas
        ]);
    }

    /**
     * @Route("/commander", name="commande_visa_classic")
     */
    public function visaClassicCommande(Request $request) : Response
    {
        $id=$request->get('typevisa');
        if($id)
        {
            $typeVisa = $this->getDoctrine()->getRepository(VisaType::class)->find($id);
            return $this->render('front_end/visa_classic/visa_classic_commande.html.twig', [
                'typeVisa'      => $typeVisa
            ]);
        }
    }

    
}