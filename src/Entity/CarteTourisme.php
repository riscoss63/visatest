<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarteTourismeRepository")
 */
class CarteTourisme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Meta", inversedBy="carteTourisme", cascade={"persist", "remove"})
     */
    private $meta;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $communique;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pays", inversedBy="carteTourisme", cascade={"persist", "remove"})
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisaType", mappedBy="carteTourisme")
     */
    private $typeVisa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoletInfo", mappedBy="carteTourisme")
     */
    private $voletsInfos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ModeExpedition", inversedBy="carteTourisme", cascade={"persist", "remove"})
     */
    private $modeExpedition;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NotreService", inversedBy="carteTourisme", cascade={"persist", "remove"})
     */
    private $notreService;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demande", mappedBy="carteTourisme")
     */
    private $demandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Actualite", mappedBy="carteTourisme")
     */
    private $actualites;

    public function __construct()
    {
        $this->typeVisa = new ArrayCollection();
        $this->voletsInfos = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->actualites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMeta(): ?Meta
    {
        return $this->meta;
    }

    public function setMeta(?Meta $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

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

    public function getCommunique(): ?string
    {
        return $this->communique;
    }

    public function setCommunique(?string $communique): self
    {
        $this->communique = $communique;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|VisaType[]
     */
    public function getTypeVisa(): Collection
    {
        return $this->typeVisa;
    }

    public function addTypeVisa(VisaType $typeVisa): self
    {
        if (!$this->typeVisa->contains($typeVisa)) {
            $this->typeVisa[] = $typeVisa;
            $typeVisa->setCarteTourisme($this);
        }

        return $this;
    }

    public function removeTypeVisa(VisaType $typeVisa): self
    {
        if ($this->typeVisa->contains($typeVisa)) {
            $this->typeVisa->removeElement($typeVisa);
            // set the owning side to null (unless already changed)
            if ($typeVisa->getCarteTourisme() === $this) {
                $typeVisa->setCarteTourisme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VoletInfo[]
     */
    public function getVoletsInfos(): Collection
    {
        return $this->voletsInfos;
    }

    public function addVoletsInfo(VoletInfo $voletsInfo): self
    {
        if (!$this->voletsInfos->contains($voletsInfo)) {
            $this->voletsInfos[] = $voletsInfo;
            $voletsInfo->setCarteTourisme($this);
        }

        return $this;
    }

    public function removeVoletsInfo(VoletInfo $voletsInfo): self
    {
        if ($this->voletsInfos->contains($voletsInfo)) {
            $this->voletsInfos->removeElement($voletsInfo);
            // set the owning side to null (unless already changed)
            if ($voletsInfo->getCarteTourisme() === $this) {
                $voletsInfo->setCarteTourisme(null);
            }
        }

        return $this;
    }

    public function getModeExpedition(): ?ModeExpedition
    {
        return $this->modeExpedition;
    }

    public function setModeExpedition(?ModeExpedition $modeExpedition): self
    {
        $this->modeExpedition = $modeExpedition;

        return $this;
    }

    public function getNotreService(): ?NotreService
    {
        return $this->notreService;
    }

    public function setNotreService(?NotreService $notreService): self
    {
        $this->notreService = $notreService;

        return $this;
    }

    public function getTitre() : ?string
    {
        return $this->getPays()->getTitre();
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
            $demande->setCarteTourisme($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getCarteTourisme() === $this) {
                $demande->setCarteTourisme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Actualite[]
     */
    public function getActualites(): Collection
    {
        return $this->actualites;
    }

    public function addActualite(Actualite $actualite): self
    {
        if (!$this->actualites->contains($actualite)) {
            $this->actualites[] = $actualite;
            $actualite->setCarteTourisme($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): self
    {
        if ($this->actualites->contains($actualite)) {
            $this->actualites->removeElement($actualite);
            // set the owning side to null (unless already changed)
            if ($actualite->getCarteTourisme() === $this) {
                $actualite->setCarteTourisme(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getPays()->getTitre();
    }
}
