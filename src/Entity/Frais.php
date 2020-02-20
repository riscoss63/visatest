<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FraisRepository")
 */
class Frais
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisConsulaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteConsulaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisEdition;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteEdition;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisLivraison;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteLivraison;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisEnlevement;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteEnlevement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", mappedBy="frais", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisFormulaire = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteFormulaire = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFraisConsulaire(): ?int
    {
        return $this->fraisConsulaire;
    }

    public function setFraisConsulaire(int $fraisConsulaire): self
    {
        $this->fraisConsulaire = $fraisConsulaire;

        return $this;
    }

    public function getQuantiteConsulaire(): ?int
    {
        return $this->quantiteConsulaire;
    }

    public function setQuantiteConsulaire(int $quantiteConsulaire): self
    {
        $this->quantiteConsulaire = $quantiteConsulaire;

        return $this;
    }

    public function getFraisEdition(): ?int
    {
        return $this->fraisEdition;
    }

    public function setFraisEdition(int $fraisEdition): self
    {
        $this->fraisEdition = $fraisEdition;

        return $this;
    }

    public function getQuantiteEdition(): ?int
    {
        return $this->quantiteEdition;
    }

    public function setQuantiteEdition(int $quantiteEdition): self
    {
        $this->quantiteEdition = $quantiteEdition;

        return $this;
    }

    public function getFraisLivraison(): ?int
    {
        return $this->fraisLivraison;
    }

    public function setFraisLivraison(int $fraisLivraison): self
    {
        $this->fraisLivraison = $fraisLivraison;

        return $this;
    }

    public function getQuantiteLivraison(): ?int
    {
        return $this->quantiteLivraison;
    }

    public function setQuantiteLivraison(int $quantiteLivraison): self
    {
        $this->quantiteLivraison = $quantiteLivraison;

        return $this;
    }

    public function getFraisEnlevement(): ?int
    {
        return $this->fraisEnlevement;
    }

    public function setFraisEnlevement(int $fraisEnlevement): self
    {
        $this->fraisEnlevement = $fraisEnlevement;

        return $this;
    }

    public function getQuantiteEnlevement(): ?int
    {
        return $this->quantiteEnlevement;
    }

    public function setQuantiteEnlevement(int $quantiteEnlevement): self
    {
        $this->quantiteEnlevement = $quantiteEnlevement;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        // set (or unset) the owning side of the relation if necessary
        $newFrais = null === $demande ? null : $this;
        if ($demande->getFrais() !== $newFrais) {
            $demande->setFrais($newFrais);
        }

        return $this;
    }

    public function getFraisFormulaire(): ?int
    {
        return $this->fraisFormulaire;
    }

    public function setFraisFormulaire(int $fraisFormulaire): self
    {
        $this->fraisFormulaire = $fraisFormulaire;

        return $this;
    }

    public function getQuantiteFormulaire(): ?int
    {
        return $this->quantiteFormulaire;
    }

    public function setQuantiteFormulaire(int $quantiteFormulaire): self
    {
        $this->quantiteFormulaire = $quantiteFormulaire;

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
}
