<?php
namespace App\Controller\FrontEnd\Assurance;

use App\Entity\Assurance;
use App\Entity\Continent;
use App\Entity\PageAssurance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/assurances")
 */
class AssuranceController extends AbstractController
{
    /**
     * @Route("/liste", name="assurances_show")
     */
    public function assurancesShow()
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

        $assurances = $this->getDoctrine()->getRepository(Assurance::class)->findAll();
        $pageAssurance = $this->getDoctrine()->getRepository(PageAssurance::class)->find(1);

        return $this->render('/front_end/assurance/assurances_show.html.twig', [
            'pageAssurance'     => $pageAssurance,
            'assurances'        => $assurances,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
        ]);
    }
}