<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatDossierRepository")
 */
class EtatDossier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $manquant;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nonConforme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ReceptionDossier", inversedBy="etatDossier",cascade={"persist"})
     */
    private $receptionDossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManquant(): ?bool
    {
        return $this->manquant;
    }

    public function setManquant(?bool $manquant): self
    {
        $this->manquant = $manquant;

        return $this;
    }

    public function getNonConforme(): ?bool
    {
        return $this->nonConforme;
    }

    public function setNonConforme(?bool $nonConforme): self
    {
        $this->nonConforme = $nonConforme;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getReceptionDossier(): ?ReceptionDossier
    {
        return $this->receptionDossier;
    }

    public function setReceptionDossier(?ReceptionDossier $receptionDossier): self
    {
        $this->receptionDossier = $receptionDossier;

        return $this;
    }
}
