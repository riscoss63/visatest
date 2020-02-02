<?php

namespace App\Controller\BackEnd\Actualites;

use App\Entity\PageDivers;
use App\Form\Backend\Actualite\PageDiversType;
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
 * @Route("/gestion/page-divers")
 */
class PageDiversController extends AbstractController
{

    /**
     * @Route("/json", name="json_page_divers")
     */
    public function pageDiversJson() : Response
    {
        $actualite = $this->getDoctrine()->getRepository(PageDivers::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES      => ['id', 'titre','meta' => 'metaDescription', 'actif', 'dateCreation' => 'timestamp', 'dateModification' => 'timestamp', 'slug']

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonActualite=$serializer->serialize($actualite, 'json');
        //On retourne une réponse JSON
        return new Response($jsonActualite, 200, ['Content-Type' => 'application/json']);
    
    }

    /**
     * @Route("/show/liste", name="show_page_divers")
     */
    public function pageDiversShow() : Response
    {
        return $this->render('/back_end/actualite/page_divers_show.html.twig');
    }

    /**
     * @Route("/add/page-divers", name="add_page_divers")
     */
    public function pageDiversAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $pageDivers = new PageDivers;

        $form = $this->createForm(PageDiversType::class, $pageDivers);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($pageDivers);
            $manager->flush();
            $this->addFlash('success', 'Une page divers a était ajouter');
            return $this->redirectToRoute('edit_page_divers', [
                'id'        => $pageDivers->getId()
            ]);
        }

        return $this->render('/back_end/actualite/page_divers_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @route("/edit/page-divers-{id}", name="edit_page_divers", options={"expose"=true})
     */
    public function pageDiversEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $pageDivers = $this->getDoctrine()->getRepository(PageDivers::class)->find($id);

        $form = $this->createForm(PageDiversType::class, $pageDivers);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($pageDivers);
            $manager->flush();
            $this->addFlash('success', 'La page divers a était modifier');
        }

        return $this->render('/back_end/actualite/page_divers_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/del/page-divers-{id}", name="del_page_divers", options={"expose"=true})
     */
    public function pageDiversDel($id, EntityManagerInterface $manager)
    {
        $pageDivers = $this->getDoctrine()->getRepository(PageDivers::class)->find($id);
        $pageDivers->setMeta(null);
        if($pageDivers)
        {
            $manager->remove($pageDivers);
            $manager->flush();
            $this->addFlash('success', 'La page divers a était supprimer');

        }

        return $this->redirectToRoute('show_page_divers');
    }
}