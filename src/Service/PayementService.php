<?php

namespace App\Service;

use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;

class PayementService
{
    private $manager;
    private $er;

    public function __construct(DemandeRepository $er, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->er = $er;
    }
    public function paiementValider($reference)
    {
        $demande = $this->er->findOneBy([
            'reference'     => $reference
        ]);

        $demande->setEtat('payer');
        $this->manager->persist($demande);
        $this->manager->flush();
    }
}