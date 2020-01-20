<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageAssuranceRepository")
 */
class PageAssurance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Meta", inversedBy="pageAssurance", cascade={"persist", "remove"})
     */
    private $meta;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $communique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $garantieAssurance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoletInfo", mappedBy="pageAssurance")
     */
    private $voletInfo;

    public function __construct()
    {
        $this->voletInfo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

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

    public function getCommunique(): ?string
    {
        return $this->communique;
    }

    public function setCommunique(?string $communique): self
    {
        $this->communique = $communique;

        return $this;
    }

    public function getGarantieAssurance(): ?string
    {
        return $this->garantieAssurance;
    }

    public function setGarantieAssurance(?string $garantieAssurance): self
    {
        $this->garantieAssurance = $garantieAssurance;

        return $this;
    }

    /**
     * @return Collection|VoletInfo[]
     */
    public function getVoletInfo(): Collection
    {
        return $this->voletInfo;
    }

    public function addVoletInfo(VoletInfo $voletInfo): self
    {
        if (!$this->voletInfo->contains($voletInfo)) {
            $this->voletInfo[] = $voletInfo;
            $voletInfo->setPageAssurance($this);
        }

        return $this;
    }

    public function removeVoletInfo(VoletInfo $voletInfo): self
    {
        if ($this->voletInfo->contains($voletInfo)) {
            $this->voletInfo->removeElement($voletInfo);
            // set the owning side to null (unless already changed)
            if ($voletInfo->getPageAssurance() === $this) {
                $voletInfo->setPageAssurance(null);
            }
        }

        return $this;
    }

}
