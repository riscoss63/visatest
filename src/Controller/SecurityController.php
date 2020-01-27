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
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        //On crée une entité User
        $user= new User;

        //Le formulaire d'inscription
        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        $errors = $form['email']->getErrors();
        if($errors)
        {
            $this->addFlash('danger', $errors);
        }
        //Si le formulaire d'inscription est valider et valide
        if($form->isSubmitted() AND $form->isValid())
        {
            //On crée un mdp aleatoire
            $random = random_int(10, 15);
            $password = random_bytes($random);
            //encode grâce a l'encodage auto
            $user->setPassword($encoder->encodePassword($user, bin2hex($password)));

            $user->setDateCreation(new \DateTime("now"));

            //Envoie de mail inscription
            $message= (new \Swift_Message('Inscription visa en ligne'))
                ->setFrom('sghairipro63@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'front_end/emails/inscription.html.twig',
                        [
                            'mdp'   => bin2hex($password),
                            'client'        => $user
                        ]
                    ),
                    'text/html'
            );
            $mailer->send($message);

            //On enregistre notre nouveau utilisateur
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Inscription terminer, vous allez recevoir par mail vos identifiants de connexion');

            //On redirige vers la page de membres
            return $this->redirectToRoute('app_login');
        }
        //On récupere l'email du mdp oublie
        $emailMdpOublie = $request->get('mdp-oublie');
        if($emailMdpOublie)
        {
            //On récupere l'user
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'email'     => $emailMdpOublie
            ]);
            //Si l'user existe
            if($user)
            {
                //On génere notre token et on édit l'user et on enregistre
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $manager->flush();

                // //On génére l'url pour éditer le mdp
                // $url = $this->generateUrl('', [
                //     'token'     => $token
                // ]);
                // $message= (new \Swift_Message('Mot de passe oublié : Visa en ligne'))
                //     ->setFrom('sghairipro63@gmail.com')
                //     ->setTo($user->getEmail())
                //     ->setBody(
                //         $this->renderView(
                //             'front_end/emails/inscription.html.twig',
                //             [
                //                 'mdp'   => bin2hex($password),
                //                 'client'        => $user
                //             ]
                //         ),
                //         'text/html'
                // );
                // $mailer->send($message);

                $this->addFlash('success', 'Un lien vous a été adressé par mail pour réinitialiser votre mot de passe');
            }

            $this->addFlash('danger', 'Adresse mail inexistante');
        }
        
        if ($this->getUser()) {
            return $this->redirectToRoute('show_users');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        
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
