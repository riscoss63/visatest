<?php

namespace App\Controller\BackEnd\VisaClassic\Demandes;

use App\Entity\Course;
use App\Entity\Demande;
use App\Entity\EtatDossier;
use App\Entity\ReceptionDossier;
use App\Entity\User;
use App\Entity\VisaType;
use App\Form\Backend\VisaClassic\CompletReceptionType;
use App\Form\Backend\VisaClassic\DemandeType;
use App\Form\Backend\VisaClassic\EtatDossierType;
use App\Form\Backend\VisaClassic\IncompletReceptionType;
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
 * @Route("/gestion/demandes")
 */
class DemandesController extends AbstractController
{
    /**
     * @Route("/liste/json-demandes", name="json_demandes_visa_classic")
     */
    public function demandesJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        $demandesVisaClassic = [];
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'commande')
            {
                $visaClassic = $demande->getVisaType()->getVisaClassic();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }
        $encoder = new JsonEncoder();
        // $defaultContext = [
        //     AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
        //         return $object->getId();
        //     },
        //     AbstractNormalizer::ATTRIBUTES      => ['id', 'client', 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic']],
        //     AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => false,

        // ];
        // $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)
        ;
        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesVisaClassic=$serializer->serialize($demandesVisaClassic, 'json', [
            AbstractNormalizer::ATTRIBUTES =>['id', 'client', 'reference', 'quantiteVisa', 'urgent', 'demande', 'visaType'=> ['visaClassic' => ['pays' => 'titre']], 'dateCreation' => 'timestamp'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ]);
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/listes/demandes-visa-classic", name="show_demandes_visa_classic")
     */
    public function demandesShow() : Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        $courseVisa = 0;
        if($courses) 
        {
            foreach ($courses as $course) 
            {
                
                if($course->getDemande()->getVisaType() != null)
                {
                    $typeVisa = $course->getDemande()->getVisaType();
                    if($typeVisa->getVisaClassic())
                    {
                        $courseVisa += 1;
                    }
                }

                $courseVisa;
            }
        }
        
        return $this->render('/back_end/visa_classic/demandes/show_demandes.html.twig', [
            'nbDeCourse'    => $courseVisa
        ]);
    }

    /**
     * @Route("/edit/demande-visa-classic-{id}", name="edit_demandes_visa_classic", options={"expose" = true})
     */
    public function demandeEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);

        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($demande);
            $manager->flush();

            return $this->redirectToRoute('show_demandes_visa_classic');
        }

        return $this->render('/back_end/visa_classic/demandes/edit_demandes.html.twig', [
            'form'      => $form->createView(),
            'demande'   => $demande
        ]);
    }

    /**
     * @Route("/liste/json-reception-dossier", name="json_reception_dossier_visa_classic")
     */
    public function receptionDossierJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            $visaClassic = $demande->getVisaType();
            $receptionDossier = $demande->getReceptionDossier();

            if($visaClassic AND $receptionDossier)
            {
                $ReceptionDossierVisaClassic[] = $receptionDossier;
            }

            $ReceptionDossierVisaClassic;
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonReceptionDossierVisaClassic=$serializer->serialize($ReceptionDossierVisaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonReceptionDossierVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/reception-dossier", name="liste_reception_dossier")
     */
    public function receptionDossierShow(Request $request, EntityManagerInterface $manager) : Response
    {    
        $referenceType=$request->request->get('reference');
        if($referenceType)
        {
            $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
                'reference'     => $referenceType
            ]);

            if($demande)
            {
                $receptionDossier = new ReceptionDossier;
                $receptionDossier->setIncomplet(true);
                $receptionDossier->setDemande($demande);
                $manager->persist($receptionDossier);
                $manager->flush();

                return $this->redirectToRoute('show_demandes_visa_classic');
            }

            elseif($demande === null AND $referenceType)
            {
                $this->addFlash('danger', 'La réference n\'existe pas');
                return $this->redirectToRoute('show_demandes_visa_classic');
            }
        }
        

        
        
        return $this->render('/back_end/visa_classic/demandes/show_reception_dossier.html.twig');
    }

    /**
     * @Route("/incomplet-dossier-{id}/visa-classic", name="incomplet_visa_classic", options={"expose" = true})
     */
    public function incompletDossierVisaClassic($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $receptionDossier = $this->getDoctrine()->getRepository(ReceptionDossier::class)->find($id);

        $form = $this->createForm(IncompletReceptionType::class, $receptionDossier);
        $form->handleRequest($request);
        

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($receptionDossier);
            $manager->flush();
            return $this->redirectToRoute('show_demandes_visa_classic');
            
        }

        return $this->render('/back_end/visa_classic/demandes/incomplet_reception_dossier.html.twig', [
            'form'      => $form->createView(),
            'id'        => $receptionDossier->getId()
        ]);
    }

    /**
     * @Route("/complet-dossier-{id}/visa-classic", name="complet_dossier_visa_classic", options={"expose" = true})
     */
    public function completDossierVisaClassic($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $receptionDossier = $this->getDoctrine()->getRepository(ReceptionDossier::class)->find($id);
        $demande = $receptionDossier->getDemande();
        $form= $this->createForm(CompletReceptionType::class, $receptionDossier);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $demande->setEtat('encours');

            $transport = $demande->getTransport();
            if($transport->getCoursier() == true)
            {
                $random = random_int(10, 15);
                $reference = random_bytes($random);
                $reference=bin2hex($reference);
                //coursier par défaut
                $coursier = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                    'roles'     => '%ROLE_COURSIER%'
                ]);
                $course = new Course;
                $course->setNom($demande->getClient()->getNom());
                $course->setPrenom($demande->getClient()->getPrenom());
                $course->setAdresse($demande->getAdresse());
                $course->setCodePostal($demande->getCodepostal());
                $course->setVille($demande->getVille());
                $course->setRealiser(false);
                $course->setCoursier($coursier);
                $course->setLivraison(true);
                $course->setDemande($demande);
                $course->setReference($reference);
                $manager->persist($course);
            }
            $manager->persist($receptionDossier);
            $manager->flush();

            return $this->redirectToRoute('show_demandes_visa_classic');
        }

        return $this->render('/back_end/visa_classic/demandes/complet_reception_dossier.html.twig', [
            'form'      => $form->createView(),
            'id'        => $receptionDossier->getId()
        ]);
    }


}