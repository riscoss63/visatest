<?php

namespace App\Controller\BackEnd\VisaClassic\Transport;

use App\Entity\TarifTransport;
use App\Entity\Transport;
use App\Form\Backend\VisaClassic\TarifTransportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/gestion/tarif-transport")
 */
class TarifTransportController extends AbstractController
{
    
    
    /**
     * @Route("/liste/json-tarif-transport-{id}", name="json_tarif_transport")
     */
    public function tarifTransportJson($id) : Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);
        $tarifsTransport = $transport->getTarifTransports();
        $encoder = new JsonEncoder();
        // $defaultContext = [
        //     AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
        //         return $object->getZone();
        //     },
        // ];
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonTarifsTransportVisaClassic=$serializer->serialize($tarifsTransport, 'json', [
            AbstractNormalizer::ATTRIBUTES      => ['id','zone', 'departement', 'prix', 'actif']
        ]);
        //On retourne une réponse JSON
        return new Response($jsonTarifsTransportVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/tarif-transport-{id}", name="show_tarif_transport", options={"expose" = true})
     */
    public function tarifTransportShow($id) : Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);

        return $this->render('/back_end/visa_classic/transports/show_tarif_transport_visa_classic.html.twig', [
            'transport'     => $transport
        ]);
    }

    /**
     * @Route("/add/tarif-transport-{id}", name="add_tarif_transport")
     */
    public function tarifTransportAdd($id, Request $request, EntityManagerInterface $manager) :Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);
        $tarifTransport = new TarifTransport;
        $tarifTransport->setTransport($transport);

        $form = $this->createForm(TarifTransportType::class, $tarifTransport);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($tarifTransport);
            $manager->flush();

            return $this->redirectToRoute('edit_tarif_transport', [
                'id'        =>  $tarifTransport->getId()
            ]);
        }

        return $this->render('/back_end/visa_classic/transports/edit_tarif_transport_visa_classic.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/tarif-transport-{id}", name="edit_tarif_transport", options={"expose" = true})
     */
    public function tarifTransportEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $tarifTransport = $this->getDoctrine()->getRepository(TarifTransport::class)->find($id);

        $form = $this->createForm(TarifTransportType::class, $tarifTransport);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($tarifTransport);
            $manager->flush();
        }

        return $this->render('/back_end/visa_classic/transports/edit_tarif_transport_visa_classic.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}