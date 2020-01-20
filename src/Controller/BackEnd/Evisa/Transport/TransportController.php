<?php

namespace App\Controller\BackEnd\Evisa\Transport;

use App\Entity\Transport;
use App\Form\Backend\VisaClassic\TransportType;
use App\Repository\TransportRepository;
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
 * @Route("/gestion/transport")
 */
class TransportController extends AbstractController
{

    private $transports;

    public function __construct(TransportRepository $transport)
    {
        $this->transports = $transport->findEvisa();
    }

    /**
     * @Route("/liste/json/evisa", name="json_transport_evisa")
     */
    public function transportJson() : Response
    {
        $transports = $this->transports;

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonTransportVisaClassic=$serializer->serialize($transports, 'json');
        //On retourne une réponse JSON
        return new Response($jsonTransportVisaClassic, 200, ['Content-Type' => 'application/json']);
    }


    /**
     * @Route("/liste/transport-evisa", name="liste_transport_evisa")
     */
    public function transportShow()
    {
        return $this->render('/back_end/evisa/transports/show_transport_evisa.html.twig', [
            'transports'        => $this->transports
        ]);
    }

    /**
     * @Route("/add/transport-evisa", name="add_transport_evisa")
     */
    public function transportAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $transport= new Transport;
        $transport->setTypeVisa('evisa');
        
        $form=$this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($transport);
            $manager->flush();

            return $this->redirectToRoute('edit_transport_evisa', [
                'id'       => $transport->getId()
            ]);
        }

        return $this->render('/back_end/evisa/transports/edit_transport_evisa.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/transport-evisa-{id}", name="edit_transport_evisa", options={"expose"=true})
     */
    public function transportEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $transport = $this->getDoctrine()->getRepository(Transport::class)->find($id);

        $form=$this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($transport);
            $manager->flush();
 
        }

        return $this->render('/back_end/evisa/transports/edit_transport_evisa.html.twig', [
            'form'      => $form->createView()
        ]);

    }
}