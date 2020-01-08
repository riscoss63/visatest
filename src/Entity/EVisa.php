<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EVisaRepository")
 */
class EVisa
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
     * @ORM\OneToOne(targetEntity="App\Entity\Meta", inversedBy="eVisa", cascade={"persist", "remove"})
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
     * @ORM\OneToOne(targetEntity="App\Entity\Pays", inversedBy="eVisa", cascade={"persist", "remove"})
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisaType", mappedBy="eVisa")
     */
    private $typeVisa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoletInfo", mappedBy="eVisa")
     */
    private $voletInfos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NotreService", inversedBy="eVisa", cascade={"persist", "remove"})
     */
    private $notreService;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ModeExpedition", inversedBy="eVisa", cascade={"persist", "remove"})
     */
    private $modeExpedition;

    public function __construct()
    {
        $this->typeVisa = new ArrayCollection();
        $this->voletInfos = new ArrayCollection();
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
            $typeVisa->setEVisa($this);
        }

        return $this;
    }

    public function removeTypeVisa(VisaType $typeVisa): self
    {
        if ($this->typeVisa->contains($typeVisa)) {
            $this->typeVisa->removeElement($typeVisa);
            // set the owning side to null (unless already changed)
            if ($typeVisa->getEVisa() === $this) {
                $typeVisa->setEVisa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VoletInfo[]
     */
    public function getVoletInfos(): Collection
    {
        return $this->voletInfos;
    }

    public function addVoletInfo(VoletInfo $voletInfo): self
    {
        if (!$this->voletInfos->contains($voletInfo)) {
            $this->voletInfos[] = $voletInfo;
            $voletInfo->setEVisa($this);
        }

        return $this;
    }

    public function removeVoletInfo(VoletInfo $voletInfo): self
    {
        if ($this->voletInfos->contains($voletInfo)) {
            $this->voletInfos->removeElement($voletInfo);
            // set the owning side to null (unless already changed)
            if ($voletInfo->getEVisa() === $this) {
                $voletInfo->setEVisa(null);
            }
        }

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

    public function getModeExpedition(): ?ModeExpedition
    {
        return $this->modeExpedition;
    }

    public function setModeExpedition(?ModeExpedition $modeExpedition): self
    {
        $this->modeExpedition = $modeExpedition;

        return $this;
    }
}
