<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeExpeditionRepository")
 */
class ModeExpedition
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
     * @ORM\OneToOne(targetEntity="App\Entity\VisaClassic", mappedBy="modeExpedition", cascade={"persist", "remove"})
     */
    private $visaClassic;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EVisa", mappedBy="modeExpedition", cascade={"persist", "remove"})
     */
    private $eVisa;

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
        $newModeExpedition = null === $visaClassic ? null : $this;
        if ($visaClassic->getModeExpedition() !== $newModeExpedition) {
            $visaClassic->setModeExpedition($newModeExpedition);
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
        $newModeExpedition = null === $eVisa ? null : $this;
        if ($eVisa->getModeExpedition() !== $newModeExpedition) {
            $eVisa->setModeExpedition($newModeExpedition);
        }

        return $this;
    }
}
