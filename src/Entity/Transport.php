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
 * @ORM\Entity(repositoryClass="App\Repository\TransportRepository")
 * @Vich\Uploadable
 */
class Transport
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $informations;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tarif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\Column(type="date")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TarifTransport", mappedBy="transport")
     */
    private $tarifTransports;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeVisa;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="transport_images", fileNameProperty="image.name", size="image.size", mimeType="image.mimeType", originalName="image.originalName", dimensions="image.dimensions")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Demande", mappedBy="transport")
     */
    private $demandes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $coursier;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $suivi;

    public function __construct()
    {
        $this->tarifTransports = new ArrayCollection();
        $this->image = new EmbeddedFile();
        $this->DateCreation = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
        $this->demandes = new ArrayCollection();
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

    public function getInformations(): ?string
    {
        return $this->informations;
    }

    public function setInformations(?string $informations): self
    {
        $this->informations = $informations;

        return $this;
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

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

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
            $tarifTransport->setTransport($this);
        }

        return $this;
    }

    public function removeTarifTransport(TarifTransport $tarifTransport): self
    {
        if ($this->tarifTransports->contains($tarifTransport)) {
            $this->tarifTransports->removeElement($tarifTransport);
            // set the owning side to null (unless already changed)
            if ($tarifTransport->getTransport() === $this) {
                $tarifTransport->setTransport(null);
            }
        }

        return $this;
    }

    public function getTypeVisa(): ?string
    {
        return $this->typeVisa;
    }

    public function setTypeVisa(?string $typeVisa): self
    {
        $this->typeVisa = $typeVisa;

        return $this;
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

    /**
     * @return Collection|Demande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setTransport($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getTransport() === $this) {
                $demande->setTransport(null);
            }
        }

        return $this;
    }

    public function getCoursier(): ?bool
    {
        return $this->coursier;
    }

    public function setCoursier(?bool $coursier): self
    {
        $this->coursier = $coursier;

        return $this;
    }

    public function getSuivi(): ?bool
    {
        return $this->suivi;
    }

    public function setSuivi(?bool $suivi): self
    {
        $this->suivi = $suivi;

        return $this;
    }

}
