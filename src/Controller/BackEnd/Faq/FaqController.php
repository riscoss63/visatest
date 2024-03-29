<?php

namespace App\Controller\BackEnd\Faq;

use App\Entity\Categorie;
use App\Entity\CategorieFaq;
use App\Entity\QuestionReponseFaq;
use App\Entity\SujetFaq;
use App\Form\Backend\Faq\CategorieFaqType;
use App\Form\Backend\Faq\QuestionReponseType;
use App\Form\Backend\Faq\SujetType;
use App\Form\FaqSujetType;
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
 * @Route("/gestion/faq")
 */
class FaqController extends AbstractController
{

    /**
     * @Route("/json/questions-reponses", name="json_questions_reponses")
     */
    public function questionsJson() : Response
    {
        $questionsReponses = $this->getDoctrine()->getRepository(QuestionReponseFaq::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonQuestionsReponses=$serializer->serialize($questionsReponses, 'json');
        //On retourne une réponse JSON
        return new Response($jsonQuestionsReponses, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/json/categories-faq", name="json_categories_faq")
     */
    public function categoriesFaqJson() : Response
    {
        $categoriesFaq = $this->getDoctrine()->getRepository(CategorieFaq::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonCategoriesFaq=$serializer->serialize($categoriesFaq, 'json');
        //On retourne une réponse JSON
        return new Response($jsonCategoriesFaq, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/json/sujets-faq", name="json_sujets_faq")
     */
    public function sujetsFaqJson() : Response
    {
        $sujetsFaq = $this->getDoctrine()->getRepository(SujetFaq::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonSujetsFaq=$serializer->serialize($sujetsFaq, 'json');
        //On retourne une réponse JSON
        return new Response($jsonSujetsFaq, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/show/questions-reponses", name="show_questions_reponses")
     */
    public function questionsReponsesShow() : Response
    {
        return $this->render('/back_end/faq/questions_reponses_show.html.twig');
    }

    /**
     * @Route("/show/categories", name="show_categories_faq")
     */
    public function categoriesFaqShow(Request $request, EntityManagerInterface $manager) : Response
    {
        $categorie = new CategorieFaq;

        $form = $this->createForm(CategorieFaqType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush();
        }

        return $this->render('/back_end/faq/categories_show.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/show/sujets-faq", name="show_sujets_faq")
     */
    public function sujetsFaqShow() : Response
    {
        return $this->render('/back_end/faq/sujets_show.html.twig');
    }

    /**
     * @Route("/add/question-reponse/{sujettitre}", name="add_question_reponse", options={"expose"=true})
     */
    public function questionReponseAdd(Request $request, EntityManagerInterface $manager, $sujettitre) : Response
    {
        $questionReponse = new QuestionReponseFaq;

        $sujet = $this->getDoctrine()->getRepository(SujetFaq::class)->findOneBy([
            'titre' => $sujettitre
        ]);
        $questionReponse->setSujetFaq($sujet);
        $form = $this->createForm(QuestionReponseType::class, $questionReponse);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($questionReponse);
            $manager->flush();

            $this->addFlash('success', 'Question / Réponse ajouter');
            return $this->redirectToRoute('show_questions_reponses');
        }

        return $this->render('/back_end/faq/questions_reponses_edit.html.twig', [
            'form'      => $form->createView(),
            'id'        => $sujettitre
        ]);
    }

    /**
     * @Route("/add/categorie", name="add_categorie_faq")
     */
    public function categorieAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $categorie = new CategorieFaq;

        $form = $this->createForm(CategorieFaqType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash('success', 'Catégorie ajouter');

            return $this->redirectToRoute('edit_categorie_faq', [
                'id'        => $categorie->getId()
            ]);
        }

        return $this->render('/back_end/faq/categories_edit.html.twig', [
            'form'          => $form->createView()
        ]);
    }

    /**
     * @Route("/add/sujet", name="add_sujet_faq")
     */
    public function sujetAdd(Request $request, EntityManagerInterface $manager) : Response
    {
        $sujet = new SujetFaq;

        $form= $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($sujet);
            $manager->flush();

            $this->addFlash('success', 'Sujet ajouter');

            return $this->redirectToRoute('show_sujets_faq');            
        }

        return $this->render('/back_end/faq/sujets_edit.html.twig', [
            'form'      =>$form->createView(),
            'id'        => $sujet->getId()
        ]);
    }

    /**
     * @Route("/add/sujet/categorie-{id}", name="add_sujet_categorie_faq", options={"expose"=true})
     */
    public function sujetCategorieAdd(Request $request, EntityManagerInterface $manager, $id) : Response
    {
        $categorie = $this->getDoctrine()->getRepository(CategorieFaq::class)->find($id);
        $sujet = new SujetFaq;
        $sujet->setCategorieFaq($categorie);

        $form= $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($sujet);
            $manager->flush();

            $this->addFlash('success', 'Sujet ajouter');

            return $this->redirectToRoute('show_categories_faq');
            
        }

        return $this->render('/back_end/faq/sujets_categorie_edit.html.twig', [
            'form'      =>$form->createView(),
            'id' => $categorie->getId()
        ]);
    }

    /**
     * @Route("/edit/question-reponse-{id}", name="edit_question_reponse", options={"expose"=true})
     */
    public function questionReponseEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $questionReponse = $this->getDoctrine()->getRepository(QuestionReponseFaq::class)->find($id);

        $form = $this->createForm(QuestionReponseType::class, $questionReponse);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($questionReponse);
            $manager->flush();

            $this->addFlash('success', 'Question / Réponse modifier');
            return $this->redirectToRoute('show_questions_reponses');
        }

        return $this->render('/back_end/faq/questions_reponses_edit.html.twig', [
            'form'      => $form->createView(),
            'id'        => $questionReponse->getId()
        ]);
    }

    /**
     * @Route("/edit/categorie-{id}", name="edit_categorie_faq", options={"expose"=true})
     */
    public function categorieEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $categorie = $this->getDoctrine()->getRepository(CategorieFaq::class)->find($id);

        $form = $this->createForm(CategorieFaqType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash('success', 'Catégorie modifier');

        }

        return $this->render('/back_end/faq/categories_edit.html.twig', [
            'form'          => $form->createView()
        ]);
        
    }

    /**
     * @Route("/edit/sujet-{id}", name="edit_sujet_faq", options={"expose"=true})
     */
    public function sujetEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $sujet = $this->getDoctrine()->getRepository(SujetFaq::class)->find($id);

        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if($form->isSubmitted() ANd $form->isValid())
        {
            $manager->persist($sujet);
            $manager->flush();
            $this->addFlash('success', 'Sujet modifier');

            return $this->redirectToRoute('show_sujets_faq');
        }
        return $this->render('/back_end/faq/sujets_edit.html.twig', [
            'form'      =>$form->createView(),
            'id'        => $sujet->getId()
        ]);
    }

    /**
     * @Route("/del/question-reponse-{id}", name="del_question_repose_faq", options={"expose"=true})
     */
    public function questionReponseDel($id, EntityManagerInterface $manager)
    {
        $questionReponse = $this->getDoctrine()->getRepository(QuestionReponseFaq::class)->find($id);

        if($questionReponse)
        {
            $manager->remove($questionReponse);
            $manager->flush();
            $this->addFlash('success', 'Question/Réponse supprimer');

        }

        return $this->redirectToRoute('show_questions_reponses');
    }

    /**
     * @Route("/del/categorie-{id}", name="del_categorie_faq", options={"expose"=true})
     */
    public function categorieDel($id, EntityManagerInterface $manager)
    {
        $categorie = $this->getDoctrine()->getRepository(CategorieFaq::class)->find($id);
        $sujets = $categorie->getSujets();
        
        if($categorie)
        {
            foreach ($sujets as $sujet) 
            {
                $categorie->removeSujet($sujet);
            }

            $manager->remove($categorie);
            $manager->flush();
            $this->addFlash('success', 'Catégorie supprimer');

        }

        return $this->redirectToRoute('show_categories_faq');
    }

    /**
     * @Route("/del/sujet-{id}", name="del_sujet_faq", options={"expose"=true})
     */
    public function sujetDel($id, EntityManagerInterface $manager)
    {
        $sujet = $this->getDoctrine()->getRepository(SujetFaq::class)->find($id);
        if($sujet)
        {
            $manager->remove($sujet);
            $manager->flush();
            $this->addFlash('success', 'Sujet supprimer');

        }

        return $this->redirectToRoute('show_sujets_faq');
        
    }

}