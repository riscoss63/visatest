<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisaClassicRepository")
 * @Vich\Uploadable
 */
class VisaClassic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="visa_classic", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Meta", cascade={"persist", "remove"})
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
     * @ORM\OneToOne(targetEntity="App\Entity\Pays", inversedBy="visaClassic", cascade={"persist", "remove"})
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VisaType", mappedBy="visaClassic")
     */
    private $typeVisa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoletInfo", mappedBy="visaClassic")
     */
    private $voletsInfos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DoccumentSupplementaire", mappedBy="visaClassic")
     */
    private $doccumentsSupplementaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ModeExpedition", inversedBy="visaClassic", cascade={"persist", "remove"})
     */
    private $modeExpedition;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NotreService", inversedBy="visaClassic", cascade={"persist", "remove"})
     */
    private $notreService;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Actualite", mappedBy="visaClassic")
     */
    private $actualites;


    public function __construct()
    {
        $this->image = new EmbeddedFile();
        $this->typeVisa = new ArrayCollection();
        $this->updatedAt = new \DateTimeImmutable();
        $this->voletsInfos = new ArrayCollection();
        $this->doccumentsSupplementaire = new ArrayCollection();
        $this->actualites = new ArrayCollection();
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image)
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
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

    public function getTitre() : ?string
    {
        return $this->getPays()->getTitre();
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
            $typeVisa->setVisaClassic($this);
        }

        return $this;
    }

    public function removeTypeVisa(VisaType $typeVisa): self
    {
        if ($this->typeVisa->contains($typeVisa)) {
            $this->typeVisa->removeElement($typeVisa);
            // set the owning side to null (unless already changed)
            if ($typeVisa->getVisaClassic() === $this) {
                $typeVisa->setVisaClassic(null);
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
            $voletsInfo->setVisaClassic($this);
        }

        return $this;
    }

    public function removeVoletsInfo(VoletInfo $voletsInfo): self
    {
        if ($this->voletsInfos->contains($voletsInfo)) {
            $this->voletsInfos->removeElement($voletsInfo);
            // set the owning side to null (unless already changed)
            if ($voletsInfo->getVisaClassic() === $this) {
                $voletsInfo->setVisaClassic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DoccumentSupplementaire[]
     */
    public function getDoccumentsSupplementaire(): Collection
    {
        return $this->doccumentsSupplementaire;
    }

    public function addDoccumentsSupplementaire(DoccumentSupplementaire $doccumentsSupplementaire): self
    {
        if (!$this->doccumentsSupplementaire->contains($doccumentsSupplementaire)) {
            $this->doccumentsSupplementaire[] = $doccumentsSupplementaire;
            $doccumentsSupplementaire->setVisaClassic($this);
        }

        return $this;
    }

    public function removeDoccumentsSupplementaire(DoccumentSupplementaire $doccumentsSupplementaire): self
    {
        if ($this->doccumentsSupplementaire->contains($doccumentsSupplementaire)) {
            $this->doccumentsSupplementaire->removeElement($doccumentsSupplementaire);
            // set the owning side to null (unless already changed)
            if ($doccumentsSupplementaire->getVisaClassic() === $this) {
                $doccumentsSupplementaire->setVisaClassic(null);
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
            $actualite->setVisaClassic($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): self
    {
        if ($this->actualites->contains($actualite)) {
            $this->actualites->removeElement($actualite);
            // set the owning side to null (unless already changed)
            if ($actualite->getVisaClassic() === $this) {
                $actualite->setVisaClassic(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getPays()->getTitre();
    }

}
