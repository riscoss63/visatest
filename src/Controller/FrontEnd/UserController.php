<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Form\RegistrationType;

class UserController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request ) : Response
    {
        $user= new User;

        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() AND $form->isValid())
        {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/_modale_inscription.html.twig', [
            'form'      =>$form->createView(),
        ]);
    }
}