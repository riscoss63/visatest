<?php

namespace App\Controller\BackEnd\Evisa\Demandes;

use App\Entity\Demande;
use App\Entity\Expedition;
use App\Entity\FraisComplementaire;
use App\Form\Backend\VisaClassic\DemandeFraisType;
use App\Form\Backend\VisaClassic\ExpeditionType;
use App\Form\Backend\VisaClassic\FraisComplementaireType;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Twig\Error\RuntimeError;

/**
 * @Route("/gestion/demandes-en-cours")
 */
class DemandesEnCoursController extends AbstractController
{
    /**
     * @Route("/liste/json", name="json_liste_demande_en_cours_visa_classic")
     */
    public function demandeEnCoursJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            if($demande->getEtat() === 'encours')
            {
                $visaClassic = $demande->getVisaType();
                if($visaClassic)
                {
                    $demandesVisaClassic[] = $demande;
                }
            }
            
            $demandesVisaClassic;
        }
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandesVisaClassic=$serializer->serialize($demandesVisaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonDemandesVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/liste/demande-visa-classic", name="show_demande_en_cours_visa_classic")
     */
    public function demandeEnCoursShow() :Response
    {
        return $this->render('/back_end/visa_classic/demandes/show_demandes_en_cours.html.twig');
    }

    /**
     * @Route("/frais-complementaire-{id}/visa-classic", name="frais_completementaire_visa_classic", options={"expose"=true})
     */
    public function fraisComplementaireEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $demande= $this->getDoctrine()->getRepository(Demande::class)->find($id);

        $form = $this->createForm(DemandeFraisType::class, $demande);
    
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($demande);
            $manager->flush();

            return $this->redirectToRoute('show_demande_en_cours_visa_classic');
        }
        return $this->render('/back_end/visa_classic/demandes/encours/edit_frais_complementaire.html.twig', [
            'form'      => $form->createView(),
            'id'        => $demande->getId()
        ]);
    }

    /**
     * @Route("/liste/json-expedition", name="json_expedition_visa_classic")
     */
    public function receptionDossierJson() : Response
    {
        $demandes = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        foreach($demandes as $demande)
        {
            $visaClassic = $demande->getVisaType();
            $expedition = $demande->getExpedition();

            if($visaClassic AND $expedition)
            {
                $expeditionVisaClassic[] = $expedition;
            }

            $expeditionVisaClassic;
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonExpeditionVisaClassic=$serializer->serialize($expeditionVisaClassic, 'json');
        //On retourne une réponse JSON
        return new Response($jsonExpeditionVisaClassic, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/expeditions/visa-classic", name="expedition_visa_classic")
     */
    public function expeditionsShow(Request $request, EntityManagerInterface $manager) : Response
    {
        $formAjout = $this->createFormBuilder()
            ->add('reference', TextType::class, [
                'attr'      => [
                    'placeholder'   => '  reference de la demande'
                ]
                
            ])
            ->add('submit', SubmitType::class, [
                'label'     => 'Ajouter'
            ])
            ->getForm()
        ;
        
        $formAjout->handleRequest($request);

        if($formAjout->isSubmitted())
        {

            $referenceType=$formAjout->getData('reference');
            $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
                'reference'     => $referenceType
            ]);

            if($demande)
            {
                $expedition = new Expedition;

                $expedition->setDemande($demande);
                $manager->persist($expedition);
                $manager->flush();
                
                return $this->redirectToRoute('show_demande_en_cours_visa_classic');
            }
            else
            {
                $formAjout->addError(new FormError('demande inexistante'));

                return $this->redirectToRoute('show_demande_en_cours_visa_classic');
            }
        }

        return $this->render('/back_end/visa_classic/demandes/encours/edit_expedition.html.twig', [
            'formAjout'     => $formAjout->createView(),
        ]);
    }

    /**
     * @Route("/edit/expedition-{id}", name="edit_expedition_visa_classic", options={"expose"=true})
     */
    public function expeditionEdit($id, Request $request, EntityManagerInterface $manager) : Response
    {
        $expedition = $this->getDoctrine()->getRepository(Expedition::class)->find($id);

        if($expedition)
        {
            $suivi = $request->request->get('suivi');
            $expedition->setSuivi($suivi);
            $manager->persist($expedition);
            $manager->flush();

            return $this->redirectToRoute('show_demande_en_cours_visa_classic');
        }
    }
}