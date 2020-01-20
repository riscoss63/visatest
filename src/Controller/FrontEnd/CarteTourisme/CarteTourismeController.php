<?php
namespace App\Controller\FrontEnd\CarteTourisme;

use App\Entity\CarteTourisme;
use App\Entity\Continent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/carte-tourisme")
 */
class CarteTourismeController extends AbstractController
{
    /**
     * @Route("/cuba", name="cuba_show")
     */
    public function cubaShow() : Response
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

        $cuba = $this->getDoctrine()->getRepository(CarteTourisme::class)->find(1);
        return $this->render('/front_end/carte_tourisme/cuba_show.html.twig', [
            'cuba'      => $cuba,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas
        ]);
    }
}