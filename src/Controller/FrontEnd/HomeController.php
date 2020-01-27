<?php

namespace App\Controller\FrontEnd;

use App\Entity\Actualite;
use App\Entity\Continent;
use App\Entity\EVisa;
use App\Entity\Home;
use App\Entity\VisaClassic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeShow() : Response
    {
        $home = $this->getDoctrine()->getRepository(Home::class)->find(1);
        $evisa = $this->getDoctrine()->getRepository(EVisa::class)->findAll();
        $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->findAll();
        $actualites = $this->getDoctrine()->getRepository(Actualite::class)->findBy([], [
            'dateModification' => 'desc'
        ]);
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
        // var_dump($visasClassics);
        return $this->render('/front_end/home/home.html.twig', [
            'home'      =>$home,
            'evisas'     => $evisa,
            'visaClassics'  => $visaClassic,
            'actualites'    => $actualites,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas
        ]);
        
    }
}