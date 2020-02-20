<?php

namespace App\Controller\Test;

use App\Entity\Demande;
use App\Entity\InfosEntreprise;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * @Route("/test", name="test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/1", name="environement")
     */
    public function environnementTest()
    {
        return new Response(
            $_ENV["MONETICOPAIEMENT_KEY"],
            Response::HTTP_OK,
            ['content-type'     => 'text/html']
        );
    }

    /**
     * @Route("/demande-{id}", name="environement")
     */
    public function environnement($id, Pdf $pdf)
    {
        $commande = $this->getDoctrine()->getRepository(Demande::class)->find($id);
        $reference = $commande->getReference();

        $html = $this->renderView('/front_end/pdf/visa_classic/bon_de_commande.html.twig',   
            [
                'demande'  => $commande,
                'entreprise'    => $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy(
                    [
                        'typeVisa'  => 'visa_classic'
                    ]
                ),
            ]
        );

        $filename = sprintf('test-%s.pdf', date('Y-m-d'));
        
        // return new Response(
        //     $pdf->getOutputFromHtml($html),
        //     200,
        //     array(
        //         'Content-Type'          => 'application/pdf',
        //         'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
        //     )
        // );


        return $this->render('/front_end/pdf/visa_classic/bon_de_commande.html.twig', [
            'demande'   => $commande,
            'entreprise'    => $this->getDoctrine()->getRepository(InfosEntreprise::class)->findOneBy([
                'typeVisa'  => 'visa_classic'
            ]),
        ]);
    }

    
}