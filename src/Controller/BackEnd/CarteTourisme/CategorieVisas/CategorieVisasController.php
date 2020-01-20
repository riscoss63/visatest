<?php

namespace App\Controller\BackEnd\CarteTourisme\CategorieVisas;

use App\Entity\CarteTourisme;
use App\Entity\CategorieVisa;
use App\Entity\DoccumentFacultatif;
use App\Entity\DoccumentObligatoire;
use App\Entity\DoccumentOfficiel;
use App\Entity\VisaClassic;
use App\Form\Backend\VisaClassic\CategorieDoccumentFacultatifAjoutType;
use App\Form\Backend\VisaClassic\CategorieDoccumentFacultatifModifType;
use App\Form\Backend\VisaClassic\CategorieDoccumentObligatoiresAjoutType;
use App\Form\Backend\VisaClassic\CategorieDoccumentObligatoiresModifType;
use App\Form\Backend\VisaClassic\FormulaireOfficielEditType;
use App\Form\Backend\VisaClassic\FormulaireOfficielType;
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
 * @Route("/gestion/categorie-carte-tourisme")
 */
class CategorieVisasController extends AbstractController
{
    // private $serviceCategorieVisaClassic;

    // public function __construct(ServicesRepository $service)
    // {   
    //     $this->serviceCategorieVisaClassic= $service->findCategorieVisaClassic();

    //     // $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);
    // }
    
    /**
     * @Route("/liste-{id}", name="json_categorie_carte_tourisme")
     */
    public function categorieCarteTourismeJson($id) : Response
    {

        $carteTourisme= $this->getDoctrine()->getRepository(CarteTourisme::class)->find($id);
        $typeCarteTourisme= $carteTourisme->getTypeVisa();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonTypeCarteTourisme=$serializer->serialize($typeCarteTourisme, 'json');
        //On retourne une réponse JSON
        return new Response($jsonTypeCarteTourisme, 200, ['Content-Type' => 'application/json']);
    }

    // /**
    //  * @Route("/doccument-obligatoire-json-{id}", name="json_categorie_doccument_obligatoire_")
    //  */
    // public function categorieJson($id) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $categorie= $this->getDoctrine()->getRepository(CategorieVisa::class)->find($id);
    //     $doccumentsObligatoire = $categorie->getDoccumentsObligatoires();
    //     $encoder = new JsonEncoder();
    //     $defaultContext = [
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
    //             return $object->getTitre();
    //         },
    //     ];
    //     $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

    //     $serializer = new Serializer([$normalizer], [$encoder]);
    //     $jsonCategorie=$serializer->serialize($doccumentsObligatoire, 'json');
    //     //On retourne une réponse JSON
    //     return new Response($jsonCategorie, 200, ['Content-Type' => 'application/json']);
    // }

    // /**
    //  * @Route("/doccument-facultatif-json-{id}", name="json_categorie_doccument_facultatif")
    //  */
    // public function categorieFacultatifJson($id) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $categorie= $this->getDoctrine()->getRepository(CategorieVisa::class)->find($id);
    //     $doccumentsObligatoire = $categorie->getDoccumentsFacultatifs();
    //     $encoder = new JsonEncoder();
    //     $defaultContext = [
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
    //             return $object->getTitre();
    //         },
    //     ];
    //     $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

    //     $serializer = new Serializer([$normalizer], [$encoder]);
    //     $jsonCategorie=$serializer->serialize($doccumentsObligatoire, 'json');
    //     //On retourne une réponse JSON
    //     return new Response($jsonCategorie, 200, ['Content-Type' => 'application/json']);
    // }

    // /**
    //  * @Route("/formulaire-officiel-json-{id}", name="json_categorie_formulaire_officiel")
    //  */
    // public function categorieOfficielJson($id) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $categorie= $this->getDoctrine()->getRepository(CategorieVisa::class)->find($id);

    //     $doccumentsOfficiel = $categorie->getDoccumentsOfficiel();
    //     $encoder = new JsonEncoder();
    //     $defaultContext = [
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
    //             return $object->getTitre();
    //         },
    //     ];
    //     $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

    //     $serializer = new Serializer([$normalizer], [$encoder]);
    //     $jsonDoccumentOfficiel=$serializer->serialize($doccumentsOfficiel, 'json');
    //     //On retourne une réponse JSON
    //     return new Response($jsonDoccumentOfficiel, 200, ['Content-Type' => 'application/json']);
    // }

    // /**
    //  * @Route("/liste/categorie-visa-classic-{id}", name="show_categorie_visa_classic", options={"expose"=true})
    //  */
    // public function categoriesVisaClassicShow($id) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $visaClassic = $this->getDoctrine()->getRepository(VisaClassic::class)->find($id);

    //     return $this->render('/back_end/visa_classic/categorie/categorie_visa_classic_show.html.twig', [
    //         'visaClassic'       => $visaClassic
    //     ]);
    // }

    // /**
    //  * @Route("/show/listes_doccuments/categorie-{id}", name="show_listes_doccuments_categorie_visa_classic", options={"expose"=true})
    //  */
    // public function listesDoccumentsCategorieVisaClassicEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $categorie = $this->getDoctrine()->getRepository(CategorieVisa::class)->find($id);

    //     //Permet l'ajout d'un nouveau doccument obligatoire
    //     $doccumentObligatoireAjout = new DoccumentObligatoire;
    //     $obligatoireAjoutForm =$this->createForm(CategorieDoccumentObligatoiresAjoutType::class, $doccumentObligatoireAjout);
    //     $obligatoireAjoutForm->handleRequest($request);

    //     //Permet l'ajout d'un nouveau doccument facultatif
    //     $doccumentFacultatif = new DoccumentFacultatif;
        
    //     $facultatifAjoutForm = $this->createForm(CategorieDoccumentFacultatifAjoutType::class, $doccumentFacultatif);
    //     $facultatifAjoutForm->handleRequest($request);

    //     if($facultatifAjoutForm->isSubmitted() AND $facultatifAjoutForm->isValid())
    //     {
    //         $doccumentFacultatif->setCategorieVisa($categorie);
    //         $manager->persist($doccumentFacultatif);
    //         $manager->flush();
    //     }

    //     if($obligatoireAjoutForm->isSubmitted() AND $obligatoireAjoutForm->isValid())
    //     {
    //         $doccumentObligatoireAjout->setCategorieVisa($categorie);
    //         $manager->persist($doccumentObligatoireAjout);
    //         $manager->flush();
    //     }


    //     return $this->render('/back_end/visa_classic/categorie/doccuments_visa_classic_show.html.twig', [
    //         'categorie'     => $categorie,
    //         'doccuments_obligatoires_ajout'    => $obligatoireAjoutForm->createView(),
    //         'doccuments_facultatifs_ajout'     => $facultatifAjoutForm->createView()
    //     ]);
    // }

    // /**
    //  * @Route("/edit/doccument-obligatoires-{id}", name="edit_doccument_obligatoire", options={"expose"=true})
    //  */
    // public function doccumentObligatoireEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);
        
    //     $doccumentObligatoire = $this->getDoctrine()->getRepository(DoccumentObligatoire::class)->find($id);
    //     $categorie = $doccumentObligatoire->getCategorieVisa();
    //     $form = $this->createForm(CategorieDoccumentObligatoiresModifType::class, $doccumentObligatoire);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() AND $form->isValid())
    //     {
    //         $manager->persist($doccumentObligatoire);
    //         $manager->flush();

    //         return $this->redirectToRoute('show_listes_doccuments_categorie_visa_classic', [
    //             'id'        => $categorie->getId()
    //         ]);
    //     }

    //     return $this->render('/back_end/visa_classic/doccuments/doccuments_obligatoires_edit.html.twig', [
    //         'form'      => $form->createView(),
    //         'doc'       => $doccumentObligatoire
    //     ]);
    // }

    // /**
    //  * @route("/del/doccument-obligatoire-{id}", name="del_doccument_obligatoire", options={"expose" = true})
    //  */
    // public function doccumentObligatoireDel($id, EntityManagerInterface $manager) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $doccumentObligatoire = $this->getDoctrine()->getRepository(DoccumentObligatoire::class)->find($id);
    //     $categorie = $doccumentObligatoire->getCategorieVisa();
    //     $manager->remove($doccumentObligatoire);
    //     $manager->flush();

    //     return $this->redirectToRoute('show_listes_doccuments_categorie_visa_classic', [
    //         'id'        => $categorie->getId()
    //     ]);

    // }

    // /**
    //  * @Route("/edit/doccument-facultatif-{id}", name="edit_doccument_facultatif", options={"expose"=true})
    //  */
    // public function doccumentFacultatifEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $doccumentFacultatif = $this->getDoctrine()->getRepository(DoccumentFacultatif::class)->find($id);
        
    //     $categorie = $doccumentFacultatif->getCategorieVisa();
        
    //     $form = $this->createForm(CategorieDoccumentFacultatifModifType::class, $doccumentFacultatif);
    //     $form->handleRequest($request);
       
    //     if($form->isSubmitted() AND $form->isValid())
    //     {
    //         $manager->persist($doccumentFacultatif);
    //         $manager->flush();

            
    //         return $this->redirectToRoute('show_listes_doccuments_categorie_visa_classic', [
    //             'id'        => $categorie->getId()
    //         ]);
    //     }
       
    //     return $this->render('/back_end/visa_classic/doccuments/doccument_facultatif_edit.html.twig', [
    //         'form'      =>$form->createView(),
    //         'doc'       =>$doccumentFacultatif
    //     ]);

    // }

    // /**
    //  * @Route("/del/doccument-facultatif-{id}", name="del_doccument_facultatif", options={"expose"=true})
    //  */
    // public function doccumentFacultatifDel($id, EntityManagerInterface $manager) : Response
    // {
    //     $this->denyAccessUnlessGranted('SHOW', $this->serviceCategorieVisaClassic);

    //     $doccumentFacultatif = $this->getDoctrine()->getRepository(DoccumentFacultatif::class)->find($id);

    //     $categorie = $doccumentFacultatif->getCategorieVisa();
    //     $manager->remove($doccumentFacultatif);
    //     $manager->flush();

    //     return $this->redirectToRoute('show_listes_doccuments_categorie_visa_classic', [
    //         'id'        => $categorie->getId()
    //     ]);
    // }

    // /**
    //  * @Route("/show/formulaires-officiel/visa-type-{id}", name="show_formulaire_visa_type", options={"expose"=true})
    //  */
    // public function formulairesShow($id, Request $request, EntityManagerInterface $manager) : Response
    // {
    //     $categorie = $this->getDoctrine()->getRepository(CategorieVisa::class)->find($id);
    //     $addFormulaireOfficiel = new DoccumentOfficiel();
    //     $addFormulaireOfficiel->setCategorieVisa($categorie);

    //     $form = $this->createForm(FormulaireOfficielType::class, $addFormulaireOfficiel);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() AND $form->isValid())
    //     {
    //         $manager->persist($addFormulaireOfficiel);
    //         $manager->flush();
    //     }

    //     return $this->render('/back_end/visa_classic/categorie/formulaires_show.html.twig', [
    //         'form'      => $form->createView(),
    //         'categorie' =>$categorie
    //     ]);
    // }

    // /**
    //  * @Route("/edit/formulaire-officiel-{id}", name="edit_formulaire_officiel", options={"expose"=true})
    //  */
    // public function formulaireOfficielEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    // {
    //     $formulaireOfficiel = $this->getDoctrine()->getRepository(DoccumentOfficiel::class)->find($id);
    //     $categorie = $formulaireOfficiel->getCategorieVisa();
    //     $form = $this->createForm(FormulaireOfficielEditType::class, $formulaireOfficiel);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() AND $form->isValid())
    //     {
    //         $manager->persist($formulaireOfficiel);
    //         $manager->flush();

    //         return $this->redirectToRoute('show_formulaire_visa_type', [
    //             'id'        => $categorie->getId()
    //         ]);
    //     }

    //     return $this->render('/back_end/visa_classic/categorie/formulaires_edit.html.twig', [
    //         'form'      => $form->createView(),
    //         'categorie' => $categorie,
    //         'formulaire'=> $formulaireOfficiel
    //     ]);
    // }

    // /**
    //  * @Route("/del/formulaire-officiel-{id}", name="del_formulaire_officiel", options={"expose"=true})
    //  */
    // public function formulaireOfficielDel($id, EntityManagerInterface $manager) : Response
    // {
    //     $formulaireOfficiel = $this->getDoctrine()->getRepository(DoccumentOfficiel::class)->find($id);
    //     $categorie = $formulaireOfficiel->getCategorieVisa();
        
    //     $manager->remove($formulaireOfficiel);
    //     $manager->flush();

    //     return $this->redirectToRoute('show_formulaire_visa_type', [
    //         'id'        => $categorie->getId()
    //     ]);
    // }


}