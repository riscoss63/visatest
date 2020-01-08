<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReceptionDossierRepository")
 */
class ReceptionDossier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="receptionDossier", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $complet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $incomplet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getComplet(): ?bool
    {
        return $this->complet;
    }

    public function setComplet(?bool $complet): self
    {
        $this->complet = $complet;

        return $this;
    }

    public function getIncomplet(): ?bool
    {
        return $this->incomplet;
    }

    public function setIncomplet(?bool $incomplet): self
    {
        $this->incomplet = $incomplet;

        return $this;
    }

    public function getTitre()
    {
        return $this->demande->getTitre();
    }
}
