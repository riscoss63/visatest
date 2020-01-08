<?php

namespace App\Controller\BackEnd\Home;

use App\Entity\Home;
use App\Form\Backend\Home\HomeType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    private $serviceHome;

    public function __construct(ServicesRepository $service)
    {   
        $this->serviceHome= $service->findHome();
    }

    /**
     * Retourne la page d'accueil
     * @Route("/gestion/home-edit", name="home_edit")
     */
    public function homeEdit(Request $request, EntityManagerInterface $manager) : Response
    {
        $this->denyAccessUnlessGranted('SHOW', $this->serviceHome);

        $home = $this->getDoctrine()->getRepository(Home::class)->find(1);

        $form=$this->createForm(HomeType::class,$home);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $manager->persist($home);
            $manager->flush();
        }

        return $this->render('back_end\home\home_edit.html.twig', [
            'form'      => $form->createView()
        ]);
    }
}