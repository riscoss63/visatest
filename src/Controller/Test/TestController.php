<?php

namespace App\Controller\Test;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}