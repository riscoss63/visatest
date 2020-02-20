<?php

namespace App\Controller\FrontEnd\Paiement;

use App\Entity\Demande;
use App\Form\Frontend\Paiement\MoneticoType;
use App\Service\MoneticoPaiement;
use App\Service\PayementService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Dotenv\Dotenv;

class PaiementController extends AbstractController
{
    /**
     * @Route("/monetico-{id}", name="paiement_monetico")
     */
    public function monetico(Request $request, MoneticoPaiement $monetico, $id)
    {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
            'id'        => $id
        ]);

        $form=$monetico->genererFormData($demande);
        $action = $monetico->getFormAction();
        return $this->render('front_end/paiement/monetico.html.twig', [
            'form' => $form,
            'order' => $demande,
            'action' => $action
        ]);
    }

    /**
     * @Route("/monetico/frais-{id}", name="paiement_frais_monetico")
     */
    public function moneticoFrais(Request $request, MoneticoPaiement $monetico, $id)
    {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findOneBy([
            'id'        => $id
        ]);
        
        $frais = $demande->getFrais();
        $resteAPayer = $frais->getTotal() - $demande->getTotal() ;
        $demande->setTotal($resteAPayer);

        $form=$monetico->genererFormData($demande);
        $action = $monetico->getFormAction();
        return $this->render('front_end/paiement/monetico.html.twig', [
            'form' => $form,
            'order' => $demande,
            'action' => $action
        ]);
        
        
    }

    /**
     * @Route("/paiements/success/{id}", name="paiement_accepter")
     */
    public function paiementAccepter($id, EntityManagerInterface $manager)
    {
        $demande = $this->getDoctrine()->getRepository(Demande::class)->find($id);

        if($demande)
        {
            $demande->setEtat('payer');
            $demande->setPayer(true);
            $demande->setTotal($demande->getFrais()->getTotal());

            $manager->persist($demande);
            $manager->flush();

            return $this->render('front_end/paiement/accepter.html.twig');
        }

        return $this->redirectToRoute('home');
        


    }

    
}