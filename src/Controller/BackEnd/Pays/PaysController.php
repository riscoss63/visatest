<?php

namespace App\Controller\BackEnd\Pays;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServicesRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Pays;
use App\Form\Backend\Pays\PaysType;

/**
 * @Route("/gestion/pays")
 */
class PaysController extends AbstractController
{
    private $servicePays;

    public function __construct(ServicesRepository $service)
    {   
        $this->servicePays= $service->findPays();
    }

    /**
     * @Route("/liste/json", name="json_pays")
     */
    public function paysJson() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePays);

        $pays= $this->getDoctrine()->getRepository(Pays::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES  => ['iso', 'titre', 'zoneGeographique', 'id'],

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonPays=$serializer->serialize($pays, 'json');
        //On retourne une réponse JSON
        return new Response($jsonPays, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste", name="show_pays")
     */
    public function paysShow() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePays);

        return $this->render('/back_end/pays/pays_show.html.twig');
    }

    /**
     * @Route("/add", name="add_pays")
     */
    public function paysAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePays);

        $pays = new Pays;

        $form = $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($pays);
            $manager->flush();

            return $this->redirectToRoute('edit_pays', [
                'id'        => $pays->getId()
            ]);
        }

        return $this->render('/back_end/pays/pays_edit.html.twig', [
            'form'      => $form->createView()
        ]);
        
    }

    /**
     * @Route("/edit-{id}", name="edit_pays", options={"expose"=true})
     */
    public function paysEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->servicePays);

        $pays = $this->getDoctrine()->getRepository(Pays::class)->find($id);

        $form= $this->createForm(PaysType::class, $pays);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($pays);
            $manager->flush();
        }

        return $this->render('/back_end/pays/pays_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    
}