<?php

namespace App\Controller\BackEnd\CarteTourisme;

use App\Entity\CarteTourisme;
use App\Entity\VisaType;
use App\Form\Backend\VisaClassic\TypeVisaClassicType;
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
 * @Route("/gestion/carte-tourisme-type")
 */
class CarteTourismeTypeController extends AbstractController
{
    /**
     * @Route("/liste-{id}/json", name="json_type_carte_tourisme")
     */
    public function typeCarteTourismeJson($id) : Response
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

    /**
     * 
     * @Route("/liste/type-carte-tourisme-{id}", name="show_type_carte_tourisme", options={"expose"=true})
     */
    public function typeCarteTourismeShow($id) : Response
    {

        $carteTourisme = $this->getDoctrine()->getRepository(CarteTourisme::class)->find($id);
        return $this->render('/back_end/carte_de_tourisme/type_show.html.twig', [
            'carteTourisme'       =>$carteTourisme
        ]);
    }

    /**
     * @Route("/add-type/carte-tourisme-{id}", name="add_type_carte_tourisme")
     */
    public function typeCarteTourismeAdd(Request $request, EntityManagerInterface $manager, $id) : Response
    {

        $typeCarteTourisme = new VisaType;
        $carteTourisme = $this->getDoctrine()->getRepository(CarteTourisme::class)->find($id);
        $typeCarteTourisme->setCarteTourisme($carteTourisme);

        $form = $this->createForm(TypeVisaClassicType::class, $typeCarteTourisme);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($typeCarteTourisme);
            $manager->flush();

            return $this->redirectToRoute('edit_type_carte_tourisme', [
                'id'        =>$typeCarteTourisme->getId()
            ]);
        }

        return $this->render('/back_end/carte_de_tourisme/type_edit.html.twig', [
            'form'      => $form->createView()
        ]);

    }

    /**
     * @Route("/edit/type-carte-tourisme-{id}", name="edit_type_carte_tourisme", options={"expose"=true})
     */
    public function typeCarteTourismeEdit(Request $request, EntityManagerInterface $manager, $id) : Response
    {

        $typeVisaClassic = $this->getDoctrine()->getRepository(VisaType::class)->find($id);

        $form = $this->createForm(TypeVisaClassicType::class, $typeVisaClassic);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($typeVisaClassic);
            $manager->flush();
        }

        return $this->render('/back_end/carte_de_tourisme/type_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}