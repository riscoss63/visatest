<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SujetFaqRepository")
 */
class SujetFaq
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
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieFaq", inversedBy="sujets")
     */
    private $categorieFaq;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionReponseFaq", mappedBy="sujetFaq")
     */
    private $questionsReponses;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModification;

    public function __construct()
    {
        $this->questionsReponses = new ArrayCollection();
        $this->dateCreation = new \DateTime('now');
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

    public function getCategorieFaq(): ?CategorieFaq
    {
        return $this->categorieFaq;
    }

    public function setCategorieFaq(?CategorieFaq $categorieFaq): self
    {
        $this->categorieFaq = $categorieFaq;

        return $this;
    }

    /**
     * @return Collection|QuestionReponseFaq[]
     */
    public function getQuestionsReponses(): Collection
    {
        return $this->questionsReponses;
    }

    public function addQuestionsReponse(QuestionReponseFaq $questionsReponse): self
    {
        if (!$this->questionsReponses->contains($questionsReponse)) {
            $this->questionsReponses[] = $questionsReponse;
            $questionsReponse->setSujetFaq($this);
        }

        return $this;
    }

    public function removeQuestionsReponse(QuestionReponseFaq $questionsReponse): self
    {
        if ($this->questionsReponses->contains($questionsReponse)) {
            $this->questionsReponses->removeElement($questionsReponse);
            // set the owning side to null (unless already changed)
            if ($questionsReponse->getSujetFaq() === $this) {
                $questionsReponse->setSujetFaq(null);
            }
        }

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
