<?php

namespace App\Controller\BackEnd\Zones;

use App\Entity\ZoneGeographique;
use App\Form\Backend\Zones\ZoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\ServicesRepository;

/**
 * @Route("/gestion/zones")
 */
class ZonesController extends AbstractController
{

    private $serviceZones;

    public function __construct(ServicesRepository $service)
    {   
        $this->serviceZones= $service->findZones();
    }

    /**
     * @Route("/liste/json", name="json_zone")
     */
    public function zoneJson(): Response
    {
        //$encoder = new JsonEncoder();
        // $normalizer = new ObjectNormalizer();
        // $serializer = new Serializer([$normalizer], [$encoder]);
        

        // //On récupe tous nos users du back-end
        // $jsonZones=$serializer->serialize($zonesGeographique, 'json', [
        //     AbstractNormalizer::ATTRIBUTES      => ['id', 'titre', 'pays', 'valide']
        // ]);

        $this->denyAccessUnlessGranted('SHOW', $this->serviceZones);

        $zonesGeographique= $this->getDoctrine()->getRepository(ZoneGeographique::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonZones=$serializer->serialize($zonesGeographique, 'json');
        //On retourne une réponse JSON
        return new Response($jsonZones, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes", name="liste_zone")
     */
    public function zoneShow() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceZones);
        return $this->render('/back_end/zones/zone_geographique_show.html.twig');
    }

    /**
     * @Route("/add", name="add_zone")
     */
    public function zoneAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceZones);
        $zone= new ZoneGeographique;

        $form= $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($zone);
            $manager->flush();
            return $this->redirectToRoute('edit_zone', [
                'id'        => $zone->getId()
            ]);
        }
        return $this->render('/back_end/zones/zone_geographique_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit-{id}", name="edit_zone", options={"expose"=true})
     */
    public function zoneEdit(Request $request, EntityManagerInterface $manager, $id) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceZones);
        
        $zone = $this->getDoctrine()->getRepository(ZoneGeographique::class)->find($id);

        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($zone);
            $manager->flush();
        }

        return $this->render('/back_end/zones/zone_geographique_edit.html.twig', [
            'form'      => $form->createView()
        ]);

    }
}