<?php

namespace App\Controller\BackEnd\Utilisateurs;

use App\Entity\User;
use App\Form\Backend\Utilisateurs\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/gestion/clients")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/liste/json", name="json_clients")
     */
    public function clientsJson() : Response
    {
        //On initialise l'encoder et le normalizer
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);
        

        //On récupe tous nos users du back-end
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        
        if($users)
        {
            $userAdmin=[];
            foreach($users as $user) 
            {
                $roles=$user->getRoles();
                if (in_array('ROLE_CLIENT', $roles)) 
                {
                    $userAdmin[] = $user;
                }
                $userAdmin;
                
                $jsonUsers=$serializer->serialize($userAdmin, 'json', [
                    AbstractNormalizer::ATTRIBUTES      => ['id', 'username', 'nom', 'prenom', 'valide', 'roles', 'dateCreation', 'dateModif', 'premium']
                ]);
            }
        }
        
        //On retourne une réponse JSON
        return new Response($jsonUsers, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/show/clients", name="show_clients")
     */
    public function clientsShow() : Response
    {
        return $this->render('back_end\client\show_client.html.twig');
    }

    /**
     * @Route("/client/add", name="add_client")
     */
    public function clientAdd(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) : Response
    {
        $client = new User;
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            //On récupere notre psw et on l'encode
            $password=$form->get('password')->getData();
            $client->setPassword($encoder->encodePassword($client, $password));

            //On modifie da date de modification
            $client->setDateCreation(new \DateTime("now"));

            $manager->persist($client);
            $manager->flush();

            $this->addFlash('success', 'Client ajouter');
            return $this->redirectToRoute('show_clients');
        }

        return $this->render('back_end\client\edit_client.html.twig', [
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/client/edit-{id}", name="edit_client", options={"expose"=true})
     */
    public function clientEdit($id, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) : Response
    {
        $client = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            //On récupere le mot de passe en clair et l'encode grâce a l'encodage auto
            $password=$form->get('password')->getData();
            if($password != null)
            {
                $client->setPassword($encoder->encodePassword($client, $password));
            }
            $client->setPassword($client->getPassword());

            //On modifie da date de modification
            $client->setDateModif(new \DateTime("now"));

            $manager->persist($client);
            $manager->flush();

            $this->addFlash('success', 'Client modifier');
            return $this->redirectToRoute('show_clients');
        }

        return $this->render('back_end\client\edit_client.html.twig', [
            'form'      => $form->createView()
        ]); 
    }

    /**
     * @Route("/demandes/clients-{id}-json", name="json_demandes_client")
     */
    public function demandesClientJson($id) : Response
    {
        $client = $this->getDoctrine()->getRepository(User::class)->find($id);
        $demandes=$client->getDemandes();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getTitre();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $jsonDemandes=$serializer->serialize($demandes, 'json');
        //On retourne une réponse JSON
        return new Response($jsonDemandes, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/show/demandes-client-{id}", name="show_demandes_client", options={"expose"=true})
     */
    public function demandesClientShow($id) : Response
    {
        return $this->render('back_end\client\show_demandes_client.html.twig', [
            'id'        => $id
        ]);
    }
    
}