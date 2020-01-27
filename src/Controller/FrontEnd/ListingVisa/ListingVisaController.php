<?php 

namespace App\Controller\FrontEnd\ListingVisa;

use App\Data\SearchData;
use App\Entity\Continent;
use App\Entity\Pays;
use App\Entity\ZoneGeographique;
use App\Form\Frontend\SearchType;
use App\Repository\PaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingVisaController extends AbstractController
{
    /**
     * @Route("/listings/visa", name="listing_visa_show")
     */
    public function listingVisaShow(PaysRepository $repository, Request $request) : Response
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
        $data = new SearchData();
        $form  = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $visa = $repository->findSearch($data);
        if($form->isSubmitted() AND $form->isValid())
        {

        }

        $visas = $repository->findAll();
        $zones = $this->getDoctrine()->getRepository(ZoneGeographique::class)->findAll();
        $pays = $this->getDoctrine()->getRepository(Pays::class)->findAll();
        return $this->render('/front_end/listing_visa/listing_show.html.twig', [
            'pays'     => $pays,
            'continentsVisaClassic'    => $visasClassics,
            'continentsEvisa'          => $eVisas,
            'form'                     =>  $form->createView(),
            'zones'                    => $zones
        ]);
    }
}