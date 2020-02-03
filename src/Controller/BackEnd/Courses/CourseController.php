<?php

namespace App\Controller\BackEnd\Courses;

use App\Entity\Course;
use App\Entity\User;
use App\Form\Backend\Course\CourseEditType;
use App\Form\Backend\Course\CourseType;
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
 * @Route("/gestion/notes-de-course")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/liste/json-courses", name="json_notes_de_course")
     */
    public function demandesJson() : Response
    {
        $notesDeCourse = $this->getDoctrine()->getRepository(Course::class)->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
            AbstractNormalizer::ATTRIBUTES  => ['client', 'adresse', 'codePostal', 'id', 'ville', 'realiser', 'livraison', 'enlevement', 'reference', 'dateEnlevement' => 'timestamp', 'coursier', 'nom', 'prenom', 'classic', 'tourisme'],

        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonNotesDeCourse=$serializer->serialize($notesDeCourse, 'json');
        //On retourne une réponse JSON
        return new Response($jsonNotesDeCourse, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/notes-de-course", name="show_liste_notes_de_course")
     */
    public function notesDeCourseShow() : Response
    {
        return $this->render('/back_end/note_de_course/note_de_course_show.html.twig');
    }

    /**
     * @Route("/signature/course-{id}", name="add_signature_course", options={"expose"=true})
     */
    public function signatureCourseAdd($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);

        $form= $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $course->setRealiser(true);
            $manager->persist($course);
            $manager->flush();

            $this->addFlash('success', 'Course signé ');

            return $this->redirectToRoute('show_liste_notes_de_course');
        }

        return $this->render('/back_end/note_de_course/signature_note_de_course_add.html.twig', [
            'form'      => $form->createView(),
            'course'    =>$course
        ]);
    }

    /**
     * @Route("/edit/course-{id}", name="edit_course", options={"expose"=true})
     */
    public function courseEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);

        $form= $this->createForm(CourseEditType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($course);
            $manager->flush();

            $this->addFlash('success', 'Course éditer ');

            return $this->redirectToRoute('show_liste_notes_de_course');
        }

        return $this->render('/back_end/note_de_course/note_de_course_edit.html.twig', [
            'form'      => $form->createView(),
            'id'        => $course->getId()
        ]);

    }

    /**
     * @Route("/select/client", name="select_client_course")
     */
    public function clientSelect()
    {
        return $this->render('/back_end/note_de_course/client_select.html.twig');
    }

    /**
     * @Route("/add/course/client-{id}", name="add_course", options={"expose"=true})
     */
    public function courseAdd(Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer, $id) :Response
    {
        $course = new Course;
        $client = $this->getDoctrine()->getRepository(User::class)->find($id);
        $course->setClient($client);
        $reference = random_bytes(5);
        $reference=bin2hex($reference);
    
        $form = $this->createForm(CourseEditType::class, $course);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $dateEnlevement = $form->get('dateEnlevement')->getData();
            $dateEnlevementFormatter = new \DateTime($dateEnlevement);
            $course->setDateEnlevement($dateEnlevementFormatter);
            $course->setReference(\strtoupper($reference));
            $course->setNom($client->getNom());
            $course->setPrenom($client->getPrenom());
            $coursier = $course->getCoursier();

            $mailCoursier = $request->get('mail_coursier');
            $mailClient = $request->get('mail_client');
            if($mailCoursier == true)
            {
                $message= (new \Swift_Message('Course visa en ligne'))
                    ->setFrom('sghairipro63@gmail.com')
                    ->setTo($coursier->getEmail())
                    ->setBody(
                        $this->renderView(
                            'back_end/emails/course.html.twig',
                            [
                                'coursier'   => $coursier,
                                'client'        => $client,
                                'course'        => $course
                            ]
                        ),
                        'text/html'
                );
                $mailer->send($message);
                $this->addFlash('success', 'Mail envoyer au coursier ');

            }
            if($mailClient == true)
            {
                $message= (new \Swift_Message('Course visa en ligne'))
                    ->setFrom('sghairipro63@gmail.com')
                    ->setTo($client->getEmail())
                    ->setBody(
                        $this->renderView(
                            'back_end/emails/course_client.html.twig',
                            [
                                'coursier'   => $coursier,
                                'client'        => $client,
                                'course'        => $course
                            ]
                        ),
                        'text/html'
                );
                $mailer->send($message);
                $this->addFlash('success', 'Mail envoyer au client ');

            }

            $manager->persist($course);
            $manager->flush();            

            $this->addFlash('success', 'Course ajouter ');

            return $this->redirectToRoute('show_liste_notes_de_course');
        }

        return $this->render('/back_end/note_de_course/note_de_course_add.html.twig', [
            'form'      => $form->createView(),
            'id'        => $client->getId()
        ]);
    }

    /**
     * @Route("/del-{id}", name="del_course", options={"expose"=true})
     */
    public function courseDel($id, EntityManagerInterface $manager)
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        
        if($course)
        {
            $manager->remove($course);
            $manager->flush();
        }
        

        return $this->redirectToRoute('show_liste_notes_de_course');
    }
}