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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $visaClassic;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $evisa;

    /**
     * @ORM\Column(type="boolean", nullable=true)
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

    public function getVisaClassic(): ?bool
    {
        return $this->visaClassic;
    }

    public function setVisaClassic(?bool $visaClassic): self
    {
        $this->visaClassic = $visaClassic;

        return $this;
    }

    public function getEvisa(): ?bool
    {
        return $this->evisa;
    }

    public function setEvisa(?bool $evisa): self
    {
        $this->evisa = $evisa;

        return $this;
    }

    public function getCarteTourisme(): ?bool
    {
        return $this->carteTourisme;
    }

    public function setCarteTourisme(?bool $carteTourisme): self
    {
        $this->carteTourisme = $carteTourisme;

        return $this;
    }
}
