<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisaTypeRepository")
 */
class VisaType
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
    private $titre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeEntre;

    /**
     * @ORM\Column(type="integer")
     */
    private $validite;

    /**
     * @ORM\Column(type="integer")
     */
    private $dureSejour;

    /**
     * @ORM\Column(type="integer")
     */
    private $delaiObtention;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisConsulaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisEdition;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fraisFormulaireValide;

    /**
     * @ORM\Column(type="integer")
     */
    private $fraisFormulaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisaClassic", inversedBy="typeVisa")
     */
    private $visaClassic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieVisa", inversedBy="visaType")
     */
    private $categorieVisa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demande", mappedBy="visaType")
     */
    private $demandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EVisa", inversedBy="typeVisa")
     */
    private $eVisa;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getTypeEntre(): ?string
    {
        return $this->typeEntre;
    }

    public function setTypeEntre(string $typeEntre): self
    {
        $this->typeEntre = $typeEntre;

        return $this;
    }

    public function getValidite(): ?int
    {
        return $this->validite;
    }

    public function setValidite(int $validite): self
    {
        $this->validite = $validite;

        return $this;
    }

    public function getDureSejour(): ?int
    {
        return $this->dureSejour;
    }

    public function setDureSejour(int $dureSejour): self
    {
        $this->dureSejour = $dureSejour;

        return $this;
    }

    public function getDelaiObtention(): ?int
    {
        return $this->delaiObtention;
    }

    public function setDelaiObtention(int $delaiObtention): self
    {
        $this->delaiObtention = $delaiObtention;

        return $this;
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

    public function getFraisEdition(): ?int
    {
        return $this->fraisEdition;
    }

    public function setFraisEdition(int $fraisEdition): self
    {
        $this->fraisEdition = $fraisEdition;

        return $this;
    }

    public function getFraisFormulaireValide(): ?bool
    {
        return $this->fraisFormulaireValide;
    }

    public function setFraisFormulaireValide(?bool $fraisFormulaireValide): self
    {
        $this->fraisFormulaireValide = $fraisFormulaireValide;

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

    public function getVisaClassic(): ?VisaClassic
    {
        return $this->visaClassic;
    }

    public function setVisaClassic(?VisaClassic $visaClassic): self
    {
        $this->visaClassic = $visaClassic;

        return $this;
    }

    public function getCategorieVisa(): ?CategorieVisa
    {
        return $this->categorieVisa;
    }

    public function setCategorieVisa(?CategorieVisa $categorieVisa): self
    {
        $this->categorieVisa = $categorieVisa;

        return $this;
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setVisaType($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getVisaType() === $this) {
                $demande->setVisaType(null);
            }
        }

        return $this;
    }

    public function getEVisa(): ?EVisa
    {
        return $this->eVisa;
    }

    public function setEVisa(?EVisa $eVisa): self
    {
        $this->eVisa = $eVisa;

        return $this;
    }

    
}
