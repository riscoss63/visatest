<?php

namespace App\Controller\BackEnd\Assurances;

use App\Entity\Assurance;
use App\Entity\PageAssurance;
use App\Entity\PartenaireAssurance;
use App\Form\Backend\Assurance\AssuranceType;
use App\Form\Backend\Assurance\PageAssuranceType;
use App\Form\Backend\Assurance\PartenaireAssuranceType;
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
 * @Route("/gestion/assurances")
 */
class AssuranceController extends AbstractController
{
    /**
     * @Route("/page-assurance-edit", name="edit_page_assurance")
     */
    public function pageAssurance(Request $request, EntityManagerInterface $manager) : Response
    {
        $assurance = $this->getDoctrine()->getRepository(PageAssurance::class)->find(1);
        if(!$assurance)
        {
            $assurance = new PageAssurance;
        }

        $form = $this->createForm(PageAssuranceType::class, $assurance);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($assurance);
            $manager->flush();
        }

        return $this->render('/back_end/assurance/page-assurance_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/liste/json", name="json_liste_assurance")
     */
    public function demandesJson() : Response
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonAssurance=$serializer->serialize($assurance, 'json');
        //On retourne une réponse JSON
        return new Response($jsonAssurance, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/show/assurance", name="show_assurance")
     */
    public function assuranceShow(): Response
    {
        return $this->render('/back_end/assurance/assurance_show.html.twig');
    }

    /**
     * @Route("/add/assurance", name="add_assurance")
     */
    public function assuranceAdd(Request $request, EntityManagerInterface $manager)
    {
        $assurance = new Assurance;
        
        $form=$this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($assurance);
            $manager->flush();

            return $this->redirectToRoute('edit_assurance', [
                'id'    => $assurance->getId()
            ]);
        }

        return $this->render('/back_end/assurance/assurance_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/assurance-{id}", name="edit_assurance", options={"expose" = true})
     */
    public function assuranceEdit(Request $request, $id, EntityManagerInterface $manager)
    {
        $assurance = $this->getDoctrine()->getRepository(Assurance::class)->find($id);

        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($assurance);
            $manager->flush();
        }

        return $this->render('/back_end/assurance/assurance_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/partenaire/assurance", name="edit_partenaire_assurance")
     */
    public function partenaireAssuranceEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $partenaire = $this->getDoctrine()->getRepository(PartenaireAssurance::class)->find(1);

        if(!$partenaire)
        {
            $partenaire = new PartenaireAssurance;
        }
        $form = $this->createForm(PartenaireAssuranceType::class, $partenaire);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($partenaire);
            $manager->flush();
        }

        return $this->render('/back_end/assurance/partenaire_assurance_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }


}