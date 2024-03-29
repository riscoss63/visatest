<?php
namespace App\EventListener;

use App\Entity\AdressesIp;
use App\Repository\AdressesIpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Request;

class LoginListener
{
    private $manager;
    private $repo;

    public function __construct(EntityManagerInterface $manager, AdressesIpRepository $repo)
    {
        $this->manager = $manager;
        $this->repo= $repo;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        //On récupere notre user
        $user = $event->getAuthenticationToken()->getUser();

        //On récupere l'adresse ip et on la stock avec l'user
        $request= Request::createFromGlobals();
        $ips = $user->getIps();
        $adressesIp = [];

        foreach ($ips as $ip) 
        {
            $adressesIp[] = $ip->getIp();
        }

        $anonymousIp=$request->getClientIp();
        
        if(in_array($anonymousIp, $adressesIp) === false)
        {
            $ip = new AdressesIp;
            $ip->setIp($request->getClientIp());
            $ip->setUpdatedAt(new \DateTime('now'));
            $ip->setAutoriser(false);
            $user->addIp($ip);
            
            //On enregistre dans la BD
            $this->manager->persist($user);
            $this->manager->flush();     
        }
        
    }
}