<?php
namespace App\Controller\FrontEnd\Divers;

use App\Entity\Continent;
use App\Entity\PageDivers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiversController extends AbstractController
{
    /**
     * @Route("/page-{slug}", name="divers_show")
     */
    public function diversShow($slug) : Response
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

        $divers = $this->getDoctrine()->getRepository(PageDivers::class)->find($slug);
        if(!$divers)
        {
            throw $this->createNotFoundException('Cette page n\'existe pas');
        }
        
        return $this->render('/front_end/divers/divers_show.html.twig', [
            'divers'        => $divers,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
        ]);
    }
}