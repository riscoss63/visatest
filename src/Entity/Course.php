<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="courses")
     */
    private $coursier;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnlevement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $realiser;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $signature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identiteSignataire;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $livraison;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enlevement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="course", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="coursesLivraison")
     */
    private $client;

    /**
     * @ORM\Column(type="boolean")
     */
    private $classic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tourisme;

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

    public function getCoursier(): ?User
    {
        return $this->coursier;
    }

    public function setCoursier(?User $coursier): self
    {
        $this->coursier = $coursier;

        return $this;
    }

    public function getDateEnlevement(): ?\DateTimeInterface
    {
        return $this->dateEnlevement;
    }

    public function setDateEnlevement(?\DateTimeInterface $dateEnlevement): self
    {
        $this->dateEnlevement = $dateEnlevement;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTitre()
    {
        return $this->reference;
    }

    public function getRealiser(): ?bool
    {
        return $this->realiser;
    }

    public function setRealiser(?bool $realiser): self
    {
        $this->realiser = $realiser;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getIdentiteSignataire(): ?string
    {
        return $this->identiteSignataire;
    }

    public function setIdentiteSignataire(?string $identiteSignataire): self
    {
        $this->identiteSignataire = $identiteSignataire;

        return $this;
    }

    public function getLivraison(): ?bool
    {
        return $this->livraison;
    }

    public function setLivraison(?bool $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getEnlevement(): ?bool
    {
        return $this->enlevement;
    }

    public function setEnlevement(?bool $enlevement): self
    {
        $this->enlevement = $enlevement;

        return $this;
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

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getClassic(): ?bool
    {
        return $this->classic;
    }

    public function setClassic(bool $classic): self
    {
        $this->classic = $classic;

        return $this;
    }

    public function getTourisme(): ?bool
    {
        return $this->tourisme;
    }

    public function setTourisme(bool $tourisme): self
    {
        $this->tourisme = $tourisme;

        return $this;
    }

}
