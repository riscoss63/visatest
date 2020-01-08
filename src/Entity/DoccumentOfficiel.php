<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoccumentOfficielRepository")
 * @Vich\Uploadable
 */
class DoccumentOfficiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @Vich\UploadableField(mapping="doccuments_officiel", fileNameProperty="titre")
     * @var File
     */
    private $doccumentOfficielFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieVisa", inversedBy="doccumentsOfficiel")
     */
    private $categorieVisa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    public function __construct()
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDoccumentOfficielFile(): ?File
    {
        return $this->doccumentOfficielFile;
    }

    public function setDoccumentOfficielFile(?File $doccumentOfficielFile = null): void
    {
        $this->doccumentOfficielFile = $doccumentOfficielFile;

        if (null !== $doccumentOfficielFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCategorieVisa(): ?CategorieVisa
    {
        return $this->categorieVisa;
    }

    public function setCategorieVisa(?CategorieVisa $categorieVisa): self
    {
        $this->categorieVisa = $categorieVisa;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
