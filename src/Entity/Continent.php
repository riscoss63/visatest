<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContinentRepository")
 */
class Continent
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
     * @ORM\OneToMany(targetEntity="App\Entity\ZoneGeographique", mappedBy="continent")
     */
    private $zonesGeographique;

    public function __construct()
    {
        $this->zonesGeographique = new ArrayCollection();
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

    /**
     * @return Collection|ZoneGeographique[]
     */
    public function getZonesGeographique(): Collection
    {
        return $this->zonesGeographique;
    }

    public function addZonesGeographique(ZoneGeographique $zonesGeographique): self
    {
        if (!$this->zonesGeographique->contains($zonesGeographique)) {
            $this->zonesGeographique[] = $zonesGeographique;
            $zonesGeographique->setContinent($this);
        }

        return $this;
    }

    public function removeZonesGeographique(ZoneGeographique $zonesGeographique): self
    {
        if ($this->zonesGeographique->contains($zonesGeographique)) {
            $this->zonesGeographique->removeElement($zonesGeographique);
            // set the owning side to null (unless already changed)
            if ($zonesGeographique->getContinent() === $this) {
                $zonesGeographique->setContinent(null);
            }
        }

        return $this;
    }
}
