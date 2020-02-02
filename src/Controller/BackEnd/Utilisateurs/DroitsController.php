<?php

namespace App\Controller\BackEnd\Utilisateurs;

use App\Entity\AdressesIp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServicesRepository;
use App\Form\Backend\Utilisateurs\ServicesType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Services;
use App\Entity\User;
use App\Form\Backend\Utilisateurs\UserAccessType;
use App\Form\Backend\Utilisateurs\UserIpType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/gestion")
 * @IsGranted("ROLE_SUPERADMIN")
 */
class DroitsController extends AbstractController
{
    private $services;

    public function __construct(ServicesRepository $service)
    {
        $this->services=$service->findAll();

    }

    /**
     * Liste des droits d'accés par roles
     * @Route("/access", name="show_acces")
     */
    public function accessShow() : Response
    {
        return $this->render('back_end\utilisateurs\droits\liste.html.twig');
    }

    /**
     * Retourne le json pour la liste des roles
     * @Route("/access/json", name="json_acces")
     */
    public function jsonGestion() : Response
    {
        //On initialise l'encoder et le normalizer
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [$encoder]);
        

        //On récupe tous nos users du back-end
        $services=$this->services;
        $jsonServices=$serializer->serialize($services, 'json', [
            AbstractNormalizer::ATTRIBUTES      => ['id', 'droits', 'service']
        ]);
        //On retourne une réponse JSON
        return new Response($jsonServices, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * Modifier l'accès à un service pour un roles
     * @Route("/access-{id}", name="edit_acces", options={"expose"=true})
     */
    public function accessEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $service = $this->getDoctrine()->getRepository(Services::class)->find($id);

        $form= $this->createForm(ServicesType::class, $service);

        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($service);
            $manager->flush();
            $this->addFlash('success', 'Accès modifier');

            return $this->redirectToRoute('show_acces');
        }
        return $this->render('back_end\utilisateurs\droits\edit_service.html.twig', [
            'form'          =>$form->createView(),
            'id'            => $service->getId()
        ]);

    }

    /**
     * Liste des utilisateurs back-end
     * @Route("/access/users", name="show_acces_user")
     */
    public function usersAccessShow(): Response
    {
        return $this->render('back_end\utilisateurs\droits\liste_users.html.twig');
    }

    /**
     * Modifier les accés d'un user en particulier
     * @Route("/access/users/edit-{id}", name="edit_acces_user", options={"expose"=true})
     */
    public function userAccessEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);

        $form=$this->createForm(UserAccessType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('show_acces_user');
            $this->addFlash('success', 'Accès utilisateur modifier');
        }

        return $this->render('back_end\utilisateurs\droits\edit_access_user.html.twig', [
            'form'  => $form->createView(),
            'id'    => $user->getId()
        ]);
    }

    /**
     * Accès a la liste des users pour les adresses ip autorisé
     * @Route("/access-ip/users", name="show_access_ip_users")
     */
    public function userAccessIpShow() : Response
    {
        return $this->render('back_end\utilisateurs\droits\liste_ip_users.html.twig');
    }

    /**
     * Modifier les adresses ips autorisé d'un user
     * @Route("/access-ip/user-{id}", name="edit_access_ip_user", options={"expose"=true})
     */
    public function userAccessIpEdit(Request $request, $id, EntityManagerInterface $manager) : Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        
        $form=$this->createForm(UserIpType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Adresse ip utilisateur modifier');
        }
        return $this->render('back_end\utilisateurs\droits\edit_ip_users.html.twig', [
            'form'      =>$form->createView(),
            'id'    => $user->getId(),
            'ips'   =>$user->getIps()
        ]);
    }

    /**
     * Ajouter une adresse ip à une user
     * @Route("/access-ip-add/ip-{id}", name="add_access_ip")
     */
    public function accessIpAdd($id, EntityManagerInterface $manager)
    {
        $ip = $this->getDoctrine()->getRepository(AdressesIp::class)->find($id);
        $ip->setAutoriser(true);
        $manager->persist($ip);
        $manager->flush();

        $this->addFlash('success', 'L\'adresse ip à était ajouter.');
        return $this->redirectToRoute('show_access_ip_users');
    }

    /**
     * Del une adresse ip à une user
     * @Route("/access-ip-del/ip-{id}", name="del_access_ip")
     */
    public function accessIpDel($id, EntityManagerInterface $manager)
    {
        $ip = $this->getDoctrine()->getRepository(AdressesIp::class)->find($id);
        $ip->setAutoriser(false);
        $manager->persist($ip);
        $manager->flush();

        $this->addFlash('success', 'L\'adresse ip à était supprimer.');
        return $this->redirectToRoute('show_access_ip_users');
    }

    
}