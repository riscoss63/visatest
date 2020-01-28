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
 * @ORM\Entity(repositoryClass="App\Repository\PageAssuranceRepository")
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="actualite", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
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

    public function getTitre()
    {
        return $this->id;
    }
}
