<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandeRepository")
 */
class Demande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="demandes")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisaType", inversedBy="demandes")
     */
    private $visaType;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteVisa;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $urgent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $entre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Transport", inversedBy="demandes")
     */
    private $transport;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ReceptionDossier", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $receptionDossier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVisaType(): ?VisaType
    {
        return $this->visaType;
    }

    public function setVisaType(?VisaType $visaType): self
    {
        $this->visaType = $visaType;

        return $this;
    }

    public function getTitre()
    {
        return $this->reference;
    }

    public function getQuantiteVisa(): ?int
    {
        return $this->quantiteVisa;
    }

    public function setQuantiteVisa(int $quantiteVisa): self
    {
        $this->quantiteVisa = $quantiteVisa;

        return $this;
    }

    public function getUrgent(): ?bool
    {
        return $this->urgent;
    }

    public function setUrgent(?bool $urgent): self
    {
        $this->urgent = $urgent;

        return $this;
    }

    public function getEntre(): ?\DateTimeInterface
    {
        return $this->entre;
    }

    public function setEntre(\DateTimeInterface $entre): self
    {
        $this->entre = $entre;

        return $this;
    }

    public function getSortie(): ?\DateTimeInterface
    {
        return $this->sortie;
    }

    public function setSortie(\DateTimeInterface $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getReceptionDossier(): ?ReceptionDossier
    {
        return $this->receptionDossier;
    }

    public function setReceptionDossier(?ReceptionDossier $receptionDossier): self
    {
        $this->receptionDossier = $receptionDossier;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = null === $receptionDossier ? null : $this;
        if ($receptionDossier->getDemande() !== $newDemande) {
            $receptionDossier->setDemande($newDemande);
        }

        return $this;
    }

}
