<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotreServiceRepository")
 */
class NotreService
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
    private $contenu;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\VisaClassic", mappedBy="notreService", cascade={"persist", "remove"})
     */
    private $visaClassic;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EVisa", mappedBy="notreService", cascade={"persist", "remove"})
     */
    private $eVisa;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CarteTourisme", mappedBy="notreService", cascade={"persist", "remove"})
     */
    private $carteTourisme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
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

        // set (or unset) the owning side of the relation if necessary
        $newNotreService = null === $visaClassic ? null : $this;
        if ($visaClassic->getNotreService() !== $newNotreService) {
            $visaClassic->setNotreService($newNotreService);
        }

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
        $newNotreService = null === $eVisa ? null : $this;
        if ($eVisa->getNotreService() !== $newNotreService) {
            $eVisa->setNotreService($newNotreService);
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
        $newNotreService = null === $carteTourisme ? null : $this;
        if ($carteTourisme->getNotreService() !== $newNotreService) {
            $carteTourisme->setNotreService($newNotreService);
        }

        return $this;
    }
}
