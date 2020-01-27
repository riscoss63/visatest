<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AssuranceRepository")
 */
class Assurance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tarif;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pays", inversedBy="assurances")
     */
    private $pays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeDuree;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demande", mappedBy="assurance")
     */
    private $demande;

    public function __construct()
    {
        $this->demande = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarif(): ?int
    {
        return $this->tarif;
    }

    public function setTarif(?int $tarif): self
    {
        $this->tarif = $tarif;

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

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getTypeDuree(): ?string
    {
        return $this->typeDuree;
    }

    public function setTypeDuree(string $typeDuree): self
    {
        $this->typeDuree = $typeDuree;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->pays->getTitre();
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemande(): Collection
    {
        return $this->demande;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demande->contains($demande)) {
            $this->demande[] = $demande;
            $demande->setAssurance($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demande->contains($demande)) {
            $this->demande->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getAssurance() === $this) {
                $demande->setAssurance(null);
            }
        }

        return $this;
    }
}
