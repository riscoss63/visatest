<?php

namespace App\Controller\BackEnd\Continents;

use App\Entity\Continent;
use App\Form\Backend\Continents\ContinentType;
use App\Repository\ServicesRepository;
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
 * @Route("/gestion/continents")
 */
class ContinentsController extends AbstractController
{
    private $serviceContinents;

    public function __construct(ServicesRepository $service)
    {   
        $this->serviceContinents= $service->findContinents();
    }

    /**
     * @Route("/liste/json", name="json_continents")
     */
    public function continentsJson() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceContinents);

        $continents= $this->getDoctrine()->getRepository(Continent::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonContinents=$serializer->serialize($continents, 'json');
        //On retourne une réponse JSON
        return new Response($jsonContinents, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste", name="show_continents")
     */
    public function continentsShow() : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceContinents);

        return $this->render('/back_end/continents/continents_show.html.twig');
    }

    /**
     * @Route("/add", name="add_continent")
     */
    public function continentAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceContinents);

        $continent = new Continent;

        $form=$this->createForm(ContinentType::class, $continent);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($continent);
            $manager->flush();

            return $this->redirectToRoute('edit_continent', [
                'id'    => $continent->getId()
            ]);
        }

        return $this->render('/back_end/continents/continents_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit-{id}", name="edit_continent", options={"expose"=true})
     */
    public function continentEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceContinents);

        $continent = $this->getDoctrine()->getRepository(Continent::class)->find($id);

        $form = $this->createForm(ContinentType::class, $continent);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($continent);
            $manager->flush();
        }

        return $this->render('/back_end/continents/continents_edit.html.twig', [
            'form'      => $form->createView()
        ]);

    }
}