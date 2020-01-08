<?php
namespace App\EventListener;

use App\Entity\AdressesIp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Request;

class LoginListener
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        //On récupere notre user
        $user = $event->getAuthenticationToken()->getUser();

        //On récupere l'adresse ip et on la stock avec l'user
        $request= Request::createFromGlobals();
        $ip = new AdressesIp;
        $ip->setIp($request->getClientIp());
        $user->addIp($ip);
        
        //On enregistre dans la BD
        $this->manager->persist($user);
        $this->manager->flush();     
    }
}