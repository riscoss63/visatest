<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DoccumentObligatoireRepository")
 */
class DoccumentObligatoire
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
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieVisa", inversedBy="doccumentsObligatoires", cascade={"persist", "remove"})
     */
    private $categorieVisa;

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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
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
}
