<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieVisaRepository")
 * @Vich\Uploadable 
 */
class CategorieVisa
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
     * @ORM\OneToMany(targetEntity="App\Entity\VisaType", mappedBy="categorieVisa", cascade={"persist", "remove"})
     */
    private $visaType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DoccumentObligatoire", mappedBy="categorieVisa", cascade={"persist", "remove"})
     */
    private $doccumentsObligatoires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DoccumentFacultatif", mappedBy="categorieVisa", cascade={"persist", "remove"})
     */
    private $doccumentsFacultatifs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DoccumentOfficiel", mappedBy="categorieVisa", cascade={"persist", "remove"})
     */
    private $doccumentsOfficiel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pays", inversedBy="categorieVisas", cascade={"persist", "remove"})
     */
    private $pays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EVisa", inversedBy="categorieVisas")
     */
    private $evisa;


    public function __construct()
    {
        $this->visaType = new ArrayCollection();
        $this->doccumentsObligatoires = new ArrayCollection();
        $this->doccumentsFacultatifs = new ArrayCollection();
        $this->doccumentsOfficiel = new ArrayCollection();
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

    /**
     * @return Collection|VisaType[]
     */
    public function getVisaType(): Collection
    {
        return $this->visaType;
    }

    public function addVisaType(VisaType $visaType): self
    {
        if (!$this->visaType->contains($visaType)) {
            $this->visaType[] = $visaType;
            $visaType->setCategorieVisa($this);
        }

        return $this;
    }

    public function removeVisaType(VisaType $visaType): self
    {
        if ($this->visaType->contains($visaType)) {
            $this->visaType->removeElement($visaType);
            // set the owning side to null (unless already changed)
            if ($visaType->getCategorieVisa() === $this) {
                $visaType->setCategorieVisa(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }

    /**
     * @return Collection|DoccumentObligatoire[]
     */
    public function getDoccumentsObligatoires(): Collection
    {
        return $this->doccumentsObligatoires;
    }

    public function addDoccumentsObligatoire(DoccumentObligatoire $doccumentsObligatoire): self
    {
        if (!$this->doccumentsObligatoires->contains($doccumentsObligatoire)) {
            $this->doccumentsObligatoires[] = $doccumentsObligatoire;
            $doccumentsObligatoire->setCategorieVisa($this);
        }

        return $this;
    }

    public function removeDoccumentsObligatoire(DoccumentObligatoire $doccumentsObligatoire): self
    {
        if ($this->doccumentsObligatoires->contains($doccumentsObligatoire)) {
            $this->doccumentsObligatoires->removeElement($doccumentsObligatoire);
            // set the owning side to null (unless already changed)
            if ($doccumentsObligatoire->getCategorieVisa() === $this) {
                $doccumentsObligatoire->setCategorieVisa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DoccumentFacultatif[]
     */
    public function getDoccumentsFacultatifs(): Collection
    {
        return $this->doccumentsFacultatifs;
    }

    public function addDoccumentsFacultatif(DoccumentFacultatif $doccumentsFacultatif): self
    {
        if (!$this->doccumentsFacultatifs->contains($doccumentsFacultatif)) {
            $this->doccumentsFacultatifs[] = $doccumentsFacultatif;
            $doccumentsFacultatif->setCategorieVisa($this);
        }

        return $this;
    }

    public function removeDoccumentsFacultatif(DoccumentFacultatif $doccumentsFacultatif): self
    {
        if ($this->doccumentsFacultatifs->contains($doccumentsFacultatif)) {
            $this->doccumentsFacultatifs->removeElement($doccumentsFacultatif);
            // set the owning side to null (unless already changed)
            if ($doccumentsFacultatif->getCategorieVisa() === $this) {
                $doccumentsFacultatif->setCategorieVisa(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|DoccumentOfficiel[]
     */
    public function getDoccumentsOfficiel(): Collection
    {
        return $this->doccumentsOfficiel;
    }

    public function addDoccumentsOfficiel(DoccumentOfficiel $doccumentsOfficiel): self
    {
        if (!$this->doccumentsOfficiel->contains($doccumentsOfficiel)) {
            $this->doccumentsOfficiel[] = $doccumentsOfficiel;
            $doccumentsOfficiel->setCategorieVisa($this);
        }

        return $this;
    }

    public function removeDoccumentsOfficiel(DoccumentOfficiel $doccumentsOfficiel): self
    {
        if ($this->doccumentsOfficiel->contains($doccumentsOfficiel)) {
            $this->doccumentsOfficiel->removeElement($doccumentsOfficiel);
            // set the owning side to null (unless already changed)
            if ($doccumentsOfficiel->getCategorieVisa() === $this) {
                $doccumentsOfficiel->setCategorieVisa(null);
            }
        }

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

    public function getEvisa(): ?EVisa
    {
        return $this->evisa;
    }

    public function setEvisa(?EVisa $evisa): self
    {
        $this->evisa = $evisa;

        return $this;
    }

}
