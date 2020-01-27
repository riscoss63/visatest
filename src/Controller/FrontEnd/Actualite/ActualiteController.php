<?php
namespace App\Controller\FrontEnd\Actualite;

use App\Entity\Actualite;
use App\Entity\Continent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ActualiteController extends AbstractController
{   
    /**
     * @Route("/actualites", name="actualites_show")
     */
    public function actualiteShow(Request $request, PaginatorInterface $paginator)
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

        $donnes = $this->getDoctrine()->getRepository(Actualite::class)->findBy([], [
            'dateModification'      =>     'desc'
        ]);
        $actualites = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1),
            9
        );
        
        return $this->render('/front_end/actualite/actualites_show.html.twig', [
            'actualites'        => $actualites,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
        ]);
    }
}