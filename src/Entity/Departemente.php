<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartementeRepository")
 */
class Departemente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomUppercase;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSoundex;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TarifTransport", mappedBy="departement")
     */
    private $tarifTransports;

    public function __construct()
    {
        $this->tarifTransports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

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

    public function getNomUppercase(): ?string
    {
        return $this->nomUppercase;
    }

    public function setNomUppercase(?string $nomUppercase): self
    {
        $this->nomUppercase = $nomUppercase;

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

    public function getNomSoundex(): ?string
    {
        return $this->nomSoundex;
    }

    public function setNomSoundex(string $nomSoundex): self
    {
        $this->nomSoundex = $nomSoundex;

        return $this;
    }

    /**
     * @return Collection|TarifTransport[]
     */
    public function getTarifTransports(): Collection
    {
        return $this->tarifTransports;
    }

    public function addTarifTransport(TarifTransport $tarifTransport): self
    {
        if (!$this->tarifTransports->contains($tarifTransport)) {
            $this->tarifTransports[] = $tarifTransport;
            $tarifTransport->setDepartement($this);
        }

        return $this;
    }

    public function removeTarifTransport(TarifTransport $tarifTransport): self
    {
        if ($this->tarifTransports->contains($tarifTransport)) {
            $this->tarifTransports->removeElement($tarifTransport);
            // set the owning side to null (unless already changed)
            if ($tarifTransport->getDepartement() === $this) {
                $tarifTransport->setDepartement(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return ''.$this->code.'  '.$this->nom  ;
    }
}
