<?php

namespace App\Controller\FrontEnd\Evisa;

use App\Entity\Continent;
use App\Entity\EVisa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evisa")
 */
class EvisaController extends AbstractController
{
    /**
     * @Route("/visa-{slug}", name="evisa_show")
     */
    public function evisaShow($slug) : Response
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

        $evisa = $this->getDoctrine()->getRepository(EVisa::class)->findOneBy([
            'slug'      => $slug
        ]);

        return $this->render('/front_end/evisa/evisa_show.html.twig', [
            'evisa'      => $evisa,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas
        ]);
    }
}