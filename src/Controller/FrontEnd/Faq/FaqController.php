<?php

namespace App\Controller\FrontEnd\Faq;

use App\Entity\CategorieFaq;
use App\Entity\Continent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/faq")
 */
class FaqController extends AbstractController
{
    /**
     * @Route("/", name="faq_show")
     */
    public function faqShow() : Response
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

        $categories = $this->getDoctrine()->getRepository(CategorieFaq::class)->findAll();

        return $this->render('front_end/faq/faq_show.html.twig', [
            'categories'        => $categories,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
        ]);
    }
}