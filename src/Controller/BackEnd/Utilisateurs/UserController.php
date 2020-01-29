<?php

namespace App\Controller\BackEnd\Utilisateurs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ServicesRepository;
use App\Entity\User;
use App\Form\Backend\Utilisateurs\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/gestion")
 */
class UserController extends AbstractController
{
    
    private $serviceUsers;

    public function __construct(ServicesRepository $service)
    {
        $this->serviceUsers=$service->findUsers();
        
    }
    
    /**
     * Vue sur tous les utilisateurs
     * @Route("/utilisateurs", name="show_users")
     * 
     */
    public function utilisateursShow(Request $request) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceUsers);
    
        return $this->render('back_end/utilisateurs/liste.html.twig');
    }

    /**
     * Retourne un json pour le bootstrap table
     * @Route("/utilisateurs/json", name="json_users")
     */
    public function utilisateursJson()
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceUsers);

        //Pour éviter les soucis de relations entre les objets        
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);


        //On initialise l'encoder et le normalizer
        // $encoder = new JsonEncoder();
        // $normalizer = new ObjectNormalizer();
        // $serializer = new Serializer([$normalizer], [$encoder]);
        

        //On récupe tous nos users du back-end
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        
        if($users)
        {
            foreach($users as $user) 
            {
                $roles=$user->getRoles();
                if (in_array('ROLE_SUPERADMIN', $roles) OR in_array('ROLE_ADMIN', $roles) OR in_array('ROLE_COURSIER', $roles) OR in_array('ROLE_REDACTEUR', $roles)) 
                {
                    $userAdmin[] = $user;
                }
                $userAdmin;
                
                $jsonUsers=$serializer->serialize($userAdmin, 'json', [
                    AbstractNormalizer::ATTRIBUTES      => ['id', 'username', 'nom', 'prenom', 'valide', 'roles', 'dateCreation', 'dateModif', 'ips' ]
                ]);
            }
        }
        
        //On retourne une réponse JSON
        return new Response($jsonUsers, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Modifier un User grâce a son id
     * @Route("/utilisateur-{id}", name="modif_user", options={"expose"=true})
     */
    public function utilisateurEdit(Request $request, $id, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, ValidatorInterface $validator) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceUsers);

        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
        $errors = $validator->validate($user);

        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() AND $form->isValid())
        {
            //On récupere le mot de passe en clair et l'encode grâce a l'encodage auto
            $password=$form->get('password')->getData();
            if($password != null)
            {
                $user->setPassword($encoder->encodePassword($user, $password));

                $message= (new \Swift_Message('Modification de votre compte : visa en ligne'))
                    ->setFrom('sghairipro63@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'back_end/emails/mdp_modifier.html.twig',
                            [
                                'mdp'   => $password,
                                'client'        => $user
                            ]
                        ),
                        'text/html'
                );
                $mailer->send($message);
            }

            //On modifie da date de modification
            $user->setDateModif(new \DateTime("now"));
            
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Utilisateur Modifier');
            
        }   
        return $this->render('back_end\utilisateurs\edit_utilisateur.html.twig', [
            'form'          =>$form->createView(),
            'errors'    => $errors
        ]);
    }

    /**
     * Création d'un nouveau utilisateur
     * @Route("/utilisateur/add", name="add_user")
     */
    public function utilisateurAdd(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, ValidatorInterface $validator) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceUsers);
        //On crée un nouveau User
        $user = new User;
        $errors = $validator->validate($user);
        //On crée le formulaire
        $form= $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        //Si le formulaire est validé et valide
        if($form->isSubmitted() AND $form->isValid())
        {
            //On récupere notre psw et on l'encode
            $password=$form->get('password')->getData();
            $user->setPassword($encoder->encodePassword($user, $password));

            //On modifie da date de modification
            $user->setDateCreation(new \DateTime("now"));

            //mail
            $message= (new \Swift_Message('Création de compte : Visa en ligne'))
                ->setFrom('sghairipro63@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'back_end/emails/add_user.html.twig',
                        [
                            'mdp'           => $password,
                            'client'        => $user
                        ]
                    ),
                    'text/html'
            );
            $mailer->send($message);

            //On enregistre dans la BD
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Utilisateur ajouter');

            //On redirige sur la modification de cette user
            return $this->redirectToRoute('modif_user', [
                'id'    =>$user->getId()
            ]);
        }
        
    
        return $this->render('back_end\utilisateurs\edit_utilisateur.html.twig', [
            'form'      => $form->createView(),
            'errors'    => $errors
        ]);
    }

    /**
     * Supprimer un user
     * @Route("/del/user-{id}", name="del_user", options={"expose"=true})
     */
    public function userDel($id, EntityManagerInterface $manager) : Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'Utilisateur supprimer');

        return $this->redirectToRoute('show_users');
    }
}