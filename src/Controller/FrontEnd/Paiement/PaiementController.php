<?php

namespace App\Controller\FrontEnd\Paiement;

use App\Entity\Demande;
use App\Form\MoneticoType;
use App\Service\MoneticoPaiement;
use App\Service\PayementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Dotenv\Dotenv;

class PaiementController extends AbstractController
{
    /**
     * @Route("/monetico/{id}", name="paiement_monetico")
     */
    public function monetico(Request $request, MoneticoPaiement $monetico, $id)
    {
        var_dump($_ENV['MONETICOPAIEMENT_KEY']);
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
            'id'        => $id
        ]);

        $form= $this->createForm(MoneticoType::class, $monetico->genererFormData($demande), [
            'action'    => $monetico->getFormAction(),
            'moneticodata' => $monetico->genererFormData($demande),
        ]);
        $form->handleRequest($request);
        return $this->render('front_end/paiement/monetico.html.twig', [
            'form' => $form->createView(),
            'order' => $demande,
        ]);
    }
}