<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\Frontend\Utilisateurs\RegistrationType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        //On crée une entité User
        $user= new User;

        //Le formulaire d'inscription
        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        
        //Si le formulaire d'inscription est valider et valide
        if($form->isSubmitted() AND $form->isValid())
        {
            //On récupere le mot de passe en clair et l'encode grâce a l'encodage auto
            $password=$form->get('password')->getData();
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setDateCreation(new \DateTime("now"));

            //On enregistre notre nouveau utilisateur
            $manager->persist($user);
            $manager->flush();

            //On redirige vers la page de membres
            return $this->redirectToRoute('app_login');
        }
        else
        {
            if ($this->getUser()) {
                return $this->redirectToRoute('show_users');
            }

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
        }
        
        return $this->render('security/login.html.twig', 
        [
            'last_username' => $lastUsername, 
            'error'         => $error,
            'form'          => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
