<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetaRepository")
 */
class Meta
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
    private $metaTitre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EVisa", mappedBy="meta", cascade={"persist", "remove"})
     */
    private $eVisa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMetaTitre(): ?string
    {
        return $this->metaTitre;
    }

    public function setMetaTitre(?string $metaTitre): self
    {
        $this->metaTitre = $metaTitre;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

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
        $newMeta = null === $eVisa ? null : $this;
        if ($eVisa->getMeta() !== $newMeta) {
            $eVisa->setMeta($newMeta);
        }

        return $this;
    }
}
