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
 * @ORM\Entity(repositoryClass="App\Repository\EVisaRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="evisa", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
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
     * @ORM\OneToMany(targetEntity="App\Entity\VisaType", mappedBy="eVisa", cascade={"persist", "remove"})
     */
    private $typeVisa;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VoletInfo", mappedBy="eVisa", cascade={"persist", "remove"})
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Actualite", mappedBy="evisa", cascade={"persist", "remove"})
     */
    private $actualites;

    public function __construct()
    {
        $this->typeVisa = new ArrayCollection();
        $this->voletInfos = new ArrayCollection();
        $this->actualites = new ArrayCollection();
        $this->image = new EmbeddedFile();
        $this->updatedAt = new \DateTimeImmutable();

    }

    public function getId(): ?int
    {
        return $this->id;
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
            $actualite->setEvisa($this);
        }

        return $this;
    }

    public function removeActualite(Actualite $actualite): self
    {
        if ($this->actualites->contains($actualite)) {
            $this->actualites->removeElement($actualite);
            // set the owning side to null (unless already changed)
            if ($actualite->getEvisa() === $this) {
                $actualite->setEvisa(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getPays()->getTitre();
    }
}
