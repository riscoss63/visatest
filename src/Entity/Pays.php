<?php

namespace App\Entity;

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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iso;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ZoneGeographique", inversedBy="pays")
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
}
