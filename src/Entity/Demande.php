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
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="demandes", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisaType", inversedBy="demandes", cascade={"persist", "remove"})
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Transport", inversedBy="demandes", cascade={"persist", "remove"})
     */
    private $transport;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ReceptionDossier", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $receptionDossier;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Course", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FraisComplementaire", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $fraisComplementaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Expedition", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $expedition;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Assurance", inversedBy="demande", cascade={"persist", "remove"})
     */
    private $assurance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voyageurs", mappedBy="demande", cascade={"persist", "remove"})
     */
    private $voyageurs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRecuperation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnvoi;

    public function __construct()
    {
        $this->fraisComplementaire = new ArrayCollection();
        $this->voyageurs = new ArrayCollection();
    }

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = null === $course ? null : $this;
        if ($course->getDemande() !== $newDemande) {
            $course->setDemande($newDemande);
        }

        return $this;
    }

    /**
     * @return Collection|FraisComplementaire[]
     */
    public function getFraisComplementaire(): Collection
    {
        return $this->fraisComplementaire;
    }

    public function addFraisComplementaire(FraisComplementaire $fraisComplementaire): self
    {
        if (!$this->fraisComplementaire->contains($fraisComplementaire)) {
            $this->fraisComplementaire[] = $fraisComplementaire;
            $fraisComplementaire->setDemande($this);
        }

        return $this;
    }

    public function removeFraisComplementaire(FraisComplementaire $fraisComplementaire): self
    {
        if ($this->fraisComplementaire->contains($fraisComplementaire)) {
            $this->fraisComplementaire->removeElement($fraisComplementaire);
            // set the owning side to null (unless already changed)
            if ($fraisComplementaire->getDemande() === $this) {
                $fraisComplementaire->setDemande(null);
            }
        }

        return $this;
    }

    public function getExpedition(): ?Expedition
    {
        return $this->expedition;
    }

    public function setExpedition(?Expedition $expedition): self
    {
        $this->expedition = $expedition;

        // set (or unset) the owning side of the relation if necessary
        $newDemande = null === $expedition ? null : $this;
        if ($expedition->getDemande() !== $newDemande) {
            $expedition->setDemande($newDemande);
        }

        return $this;
    }

    public function getAssurance(): ?Assurance
    {
        return $this->assurance;
    }

    public function setAssurance(?Assurance $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }

    /**
     * @return Collection|Voyageurs[]
     */
    public function getVoyageurs(): Collection
    {
        return $this->voyageurs;
    }

    public function addVoyageur(Voyageurs $voyageur): self
    {
        if (!$this->voyageurs->contains($voyageur)) {
            $this->voyageurs[] = $voyageur;
            $voyageur->setDemande($this);
        }

        return $this;
    }

    public function removeVoyageur(Voyageurs $voyageur): self
    {
        if ($this->voyageurs->contains($voyageur)) {
            $this->voyageurs->removeElement($voyageur);
            // set the owning side to null (unless already changed)
            if ($voyageur->getDemande() === $this) {
                $voyageur->setDemande(null);
            }
        }

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDateRecuperation(): ?\DateTimeInterface
    {
        return $this->dateRecuperation;
    }

    public function setDateRecuperation(?\DateTimeInterface $dateRecuperation): self
    {
        $this->dateRecuperation = $dateRecuperation;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): self
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }
}
