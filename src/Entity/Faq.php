<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FaqRepository")
 */
class Faq
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
     * @ORM\OneToOne(targetEntity="App\Entity\Meta", inversedBy="faq", cascade={"persist", "remove"})
     */
    private $meta;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategorieFaq", mappedBy="faq")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getMeta(): ?Meta
    {
        return $this->meta;
    }

    public function setMeta(?Meta $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * @return Collection|CategorieFaq[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(CategorieFaq $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setFaq($this);
        }

        return $this;
    }

    public function removeCategory(CategorieFaq $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getFaq() === $this) {
                $category->setFaq(null);
            }
        }

        return $this;
    }
}
