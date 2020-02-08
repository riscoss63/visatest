<?php

namespace App\Controller\BackEnd\VisaClassic\Demandes;

use App\Entity\Demande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("gestion/archives")
 */
class ArchivesController extends AbstractController
{

    /**
     * @Route("/liste/json-archives", name="json_archives_visa_classic")
     */
    public function archivesJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $demandesVisaClassic = [];
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'archive')
            {
                $visaClassic = $demande->getVisaType()->getVisaClassic();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }
        $encoder = new JsonEncoder();
       
        
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesVisaClassic=$serializer->serialize($demandesVisaClassic, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::ATTRIBUTES =>['id', 'client' => ['prenom', 'nom', 'pays', 'codePostal'], 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic' => ['pays' => ['titre']]], 'dateCreation' => ['timestamp']],
            
        ]);
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes/archives-visa-classic", name="show_archives_visa_classic")
     */
    public function archivesShow() : Response
    {        
        return $this->render('/back_end/visa_classic/demandes/archives/show_archives.html.twig');
    }
}