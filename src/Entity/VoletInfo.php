<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoletInfoRepository")
 */
class VoletInfo
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisaClassic", inversedBy="voletsInfos")
     */
    private $visaClassic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EVisa", inversedBy="voletInfos")
     */
    private $eVisa;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarteTourisme", inversedBy="voletsInfos")
     */
    private $carteTourisme;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PageAssurance", inversedBy="voletInfo")
     */
    private $pageAssurance;

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

    public function getVisaClassic(): ?VisaClassic
    {
        return $this->visaClassic;
    }

    public function setVisaClassic(?VisaClassic $visaClassic): self
    {
        $this->visaClassic = $visaClassic;

        return $this;
    }

    public function getEVisa(): ?EVisa
    {
        return $this->eVisa;
    }

    public function setEVisa(?EVisa $eVisa): self
    {
        $this->eVisa = $eVisa;

        return $this;
    }

    public function getCarteTourisme(): ?CarteTourisme
    {
        return $this->carteTourisme;
    }

    public function setCarteTourisme(?CarteTourisme $carteTourisme): self
    {
        $this->carteTourisme = $carteTourisme;

        return $this;
    }

    public function getPageAssurance(): ?PageAssurance
    {
        return $this->pageAssurance;
    }

    public function setPageAssurance(?PageAssurance $pageAssurance): self
    {
        $this->pageAssurance = $pageAssurance;

        return $this;
    }

}
