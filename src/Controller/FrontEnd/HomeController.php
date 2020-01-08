<?php

namespace App\Controller\FrontEnd;

use App\Entity\Home;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function homeShow() : Response
    {
        $home = $this->getDoctrine()->getRepository(Home::class)->find(1);

        return $this->render('/front_end/home/home.html.twig', [
            'home'      =>$home
        ]);
        
    }
}