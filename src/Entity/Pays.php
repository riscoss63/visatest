<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaysRepository")
 */
class Pays
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
    private $iso;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $virtuel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indicatif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZoneGeographique", inversedBy="pays", cascade={"persist", "remove"})
     */
    private $zoneGeographique;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\VisaClassic", mappedBy="pays", cascade={"persist", "remove"})
     */
    private $visaClassic;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EVisa", mappedBy="pays", cascade={"persist", "remove"})
     */
    private $eVisa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategorieVisa", mappedBy="pays", cascade={"persist", "remove"})
     */
    private $categorieVisas;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CarteTourisme", mappedBy="pays", cascade={"persist", "remove"})
     */
    private $carteTourisme;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Assurance", mappedBy="pays", cascade={"persist", "remove"})
     */
    private $assurances;

    

    public function __construct()
    {
        $this->categorieVisas = new ArrayCollection();
        $this->assurances = new ArrayCollection();
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

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(string $iso): self
    {
        $this->iso = $iso;

        return $this;
    }

    public function getZoneGeographique(): ?ZoneGeographique
    {
        return $this->zoneGeographique;
    }

    public function setZoneGeographique(?ZoneGeographique $zoneGeographique): self
    {
        $this->zoneGeographique = $zoneGeographique;

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }

    public function getVisaClassic(): ?VisaClassic
    {
        return $this->visaClassic;
    }

    public function setVisaClassic(?VisaClassic $visaClassic): self
    {
        $this->visaClassic = $visaClassic;

        // set (or unset) the owning side of the relation if necessary
        $newPays = null === $visaClassic ? null : $this;
        if ($visaClassic->getPays() !== $newPays) {
            $visaClassic->setPays($newPays);
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

        // set (or unset) the owning side of the relation if necessary
        $newPays = null === $eVisa ? null : $this;
        if ($eVisa->getPays() !== $newPays) {
            $eVisa->setPays($newPays);
        }

        return $this;
    }

    /**
     * @return Collection|CategorieVisa[]
     */
    public function getCategorieVisas(): Collection
    {
        return $this->categorieVisas;
    }

    public function addCategorieVisa(CategorieVisa $categorieVisa): self
    {
        if (!$this->categorieVisas->contains($categorieVisa)) {
            $this->categorieVisas[] = $categorieVisa;
            $categorieVisa->setPays($this);
        }

        return $this;
    }

    public function removeCategorieVisa(CategorieVisa $categorieVisa): self
    {
        if ($this->categorieVisas->contains($categorieVisa)) {
            $this->categorieVisas->removeElement($categorieVisa);
            // set the owning side to null (unless already changed)
            if ($categorieVisa->getPays() === $this) {
                $categorieVisa->setPays(null);
            }
        }

        return $this;
    }

    public function getCarteTourisme(): ?CarteTourisme
    {
        return $this->carteTourisme;
    }

    public function setCarteTourisme(?CarteTourisme $carteTourisme): self
    {
        $this->carteTourisme = $carteTourisme;

        // set (or unset) the owning side of the relation if necessary
        $newPays = null === $carteTourisme ? null : $this;
        if ($carteTourisme->getPays() !== $newPays) {
            $carteTourisme->setPays($newPays);
        }

        return $this;
    }

    /**
     * @return Collection|Assurance[]
     */
    public function getAssurances(): Collection
    {
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): self
    {
        if (!$this->assurances->contains($assurance)) {
            $this->assurances[] = $assurance;
            $assurance->setPays($this);
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance): self
    {
        if ($this->assurances->contains($assurance)) {
            $this->assurances->removeElement($assurance);
            // set the owning side to null (unless already changed)
            if ($assurance->getPays() === $this) {
                $assurance->setPays(null);
            }
        }

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

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getVirtuel(): ?string
    {
        return $this->virtuel;
    }

    public function setVirtuel(?string $virtuel): self
    {
        $this->virtuel = $virtuel;

        return $this;
    }

    public function getIndicatif(): ?string
    {
        return $this->indicatif;
    }

    public function setIndicatif(?string $indicatif): self
    {
        $this->indicatif = $indicatif;

        return $this;
    }
}
