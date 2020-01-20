<?php

namespace App\Controller\BackEnd\CarteTourisme\Transport;

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
 * @Route("/gestion/carte-tourisme/tarif-transport")
 */
class TarifTransportController extends AbstractController
{
    
    /**
     * @Route("/liste/json-tarif-transport-{id}", name="json_tarif_transport_carte_tourisme")
     */
    public function tarifTransportJson($id) : Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);
        $tarifsTransport = $transport->getTarifTransports();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonTarifsTransport=$serializer->serialize($tarifsTransport, 'json', [
            AbstractNormalizer::ATTRIBUTES      => ['id','zone', 'departement', 'prix', 'actif']
        ]);
        //On retourne une réponse JSON
        return new Response($jsonTarifsTransport, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/tarif-transport-{id}", name="show_tarif_transport_carte_tourisme", options={"expose" = true})
     */
    public function tarifTransportShow($id) : Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);

        return $this->render('/back_end/carte_de_tourisme/transports/show_tarif_transport_carte_tourisme.html.twig', [
            'transport'     => $transport
        ]);
    }

    /**
     * @Route("/add/tarif-transport-{id}", name="add_tarif_transport_carte_tourisme")
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

            return $this->redirectToRoute('edit_tarif_transport_carte_tourisme', [
                'id'        =>  $tarifTransport->getId()
            ]);
        }

        return $this->render('/back_end/carte_de_tourisme/transports/edit_tarif_transport_carte_tourisme.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/tarif-transport-{id}", name="edit_tarif_transport_carte_tourisme", options={"expose" = true})
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

        return $this->render('/back_end/carte_de_tourisme/transports/edit_tarif_transport_carte_tourisme.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}