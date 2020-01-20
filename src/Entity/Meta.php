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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CarteTourisme", mappedBy="meta", cascade={"persist", "remove"})
     */
    private $carteTourisme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PageAssurance", mappedBy="meta", cascade={"persist", "remove"})
     */
    private $pageAssurance;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Actualite", mappedBy="meta", cascade={"persist", "remove"})
     */
    private $actualite;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PageDivers", mappedBy="meta", cascade={"persist", "remove"})
     */
    private $pageDivers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Faq", mappedBy="meta", cascade={"persist", "remove"})
     */
    private $faq;

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

    public function getCarteTourisme(): ?CarteTourisme
    {
        return $this->carteTourisme;
    }

    public function setCarteTourisme(?CarteTourisme $carteTourisme): self
    {
        $this->carteTourisme = $carteTourisme;

        // set (or unset) the owning side of the relation if necessary
        $newMeta = null === $carteTourisme ? null : $this;
        if ($carteTourisme->getMeta() !== $newMeta) {
            $carteTourisme->setMeta($newMeta);
        }

        return $this;
    }

    public function getPageAssurance(): ?PageAssurance
    {
        return $this->pageAssurance;
    }

    public function setPageAssurance(?PageAssurance $pageAssurance): self
    {
        $this->pageAssurance = $pageAssurance;

        // set (or unset) the owning side of the relation if necessary
        $newMeta = null === $pageAssurance ? null : $this;
        if ($pageAssurance->getMeta() !== $newMeta) {
            $pageAssurance->setMeta($newMeta);
        }

        return $this;
    }

    public function getActualite(): ?Actualite
    {
        return $this->actualite;
    }

    public function setActualite(?Actualite $actualite): self
    {
        $this->actualite = $actualite;

        // set (or unset) the owning side of the relation if necessary
        $newMeta = null === $actualite ? null : $this;
        if ($actualite->getMeta() !== $newMeta) {
            $actualite->setMeta($newMeta);
        }

        return $this;
    }

    public function getTitre(): ?String
    {
        return $this->metaTitre;
    }

    public function getPageDivers(): ?PageDivers
    {
        return $this->pageDivers;
    }

    public function setPageDivers(?PageDivers $pageDivers): self
    {
        $this->pageDivers = $pageDivers;

        // set (or unset) the owning side of the relation if necessary
        $newMeta = null === $pageDivers ? null : $this;
        if ($pageDivers->getMeta() !== $newMeta) {
            $pageDivers->setMeta($newMeta);
        }

        return $this;
    }

    public function getFaq(): ?Faq
    {
        return $this->faq;
    }

    public function setFaq(?Faq $faq): self
    {
        $this->faq = $faq;

        // set (or unset) the owning side of the relation if necessary
        $newMeta = null === $faq ? null : $this;
        if ($faq->getMeta() !== $newMeta) {
            $faq->setMeta($newMeta);
        }

        return $this;
    }
}
