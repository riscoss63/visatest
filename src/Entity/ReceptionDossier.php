<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReceptionDossierRepository")
 */
class ReceptionDossier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Demande", inversedBy="receptionDossier", cascade={"persist", "remove"})
     */
    private $demande;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $complet = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $incomplet = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EtatDossier", mappedBy="receptionDossier", cascade={"persist", "remove"})
     */
    private $etatDossier;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $depot;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dossierRecu;

    public function __construct()
    {
        $this->etatDossier = new ArrayCollection();
        //liste de doccument generique
        $billetAvion = new EtatDossier();
        $billetAvion->setNom('billetAvion');

        $formulaireOfficiel = new EtatDossier;
        $formulaireOfficiel->setNom('formulaireOfficiel');

        $passeport = new EtatDossier;
        $passeport->setNom('passeport');

        $assurancevoyage = new EtatDossier;
        $assurancevoyage->setNom('assurancevoyage');

        $photoIdentite = new EtatDossier;
        $photoIdentite->setNom('photoIdentite');

        $lettreMissionCommerciale = new EtatDossier;
        $lettreMissionCommerciale->setNom('lettreMissionCommerciale');

        $lettreInvitation = new EtatDossier;
        $lettreInvitation->setNom('lettreInvitation');

        $enregistrementElectronique = new EtatDossier;
        $enregistrementElectronique->setNom('enregistrementElectronique');

        $reservationHotel= new EtatDossier;
        $reservationHotel->setNom('reservationHotel');

        $certificatHebergement = new EtatDossier;
        $certificatHebergement->setNom('certificatHebergement');

        $certificatTravail = new EtatDossier;
        $certificatTravail->setNom('certificatTravail');

        $releverBancaire = new EtatDossier;
        $releverBancaire->setNom('releverBancaire');

        $cheque = new EtatDossier;
        $cheque->setNom('cheque');

        $carteSejour = new EtatDossier;
        $carteSejour->setNom('carteSejour');

        $autre = new EtatDossier;
        $autre->setNom('autre');
        $this->addEtatDossier($billetAvion);
        $this->addEtatDossier($formulaireOfficiel);
        $this->addEtatDossier($passeport);
        $this->addEtatDossier($assurancevoyage);
        $this->addEtatDossier($photoIdentite);
        $this->addEtatDossier($lettreMissionCommerciale);
        $this->addEtatDossier($lettreInvitation);
        $this->addEtatDossier($enregistrementElectronique);
        $this->addEtatDossier($reservationHotel);
        $this->addEtatDossier($certificatHebergement);
        $this->addEtatDossier($certificatTravail);
        $this->addEtatDossier($releverBancaire);
        $this->addEtatDossier($cheque);
        $this->addEtatDossier($carteSejour);
        $this->addEtatDossier($autre);

        $this->dossierRecu = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getComplet(): ?bool
    {
        return $this->complet;
    }

    public function setComplet(?bool $complet): self
    {
        $this->complet = $complet;

        return $this;
    }

    public function getIncomplet(): ?bool
    {
        return $this->incomplet;
    }

    public function setIncomplet(?bool $incomplet): self
    {
        $this->incomplet = $incomplet;

        return $this;
    }

    public function getTitre()
    {
        return $this->demande->getTitre();
    }

    /**
     * @return Collection|EtatDossier[]
     */
    public function getEtatDossier(): Collection
    {
        return $this->etatDossier;
    }

    public function addEtatDossier(EtatDossier $etatDossier): self
    {
        if (!$this->etatDossier->contains($etatDossier)) {
            $this->etatDossier[] = $etatDossier;
            $etatDossier->setReceptionDossier($this);
        }

        return $this;
    }

    public function removeEtatDossier(EtatDossier $etatDossier): self
    {
        if ($this->etatDossier->contains($etatDossier)) {
            $this->etatDossier->removeElement($etatDossier);
            // set the owning side to null (unless already changed)
            if ($etatDossier->getReceptionDossier() === $this) {
                $etatDossier->setReceptionDossier(null);
            }
        }

        return $this;
    }

    public function getDepot(): ?\DateTimeInterface
    {
        return $this->depot;
    }

    public function setDepot(?\DateTimeInterface $depot): self
    {
        $this->depot = $depot;

        return $this;
    }

    public function getDossierRecu(): ?\DateTimeInterface
    {
        return $this->dossierRecu;
    }

    public function setDossierRecu(?\DateTimeInterface $dossierRecu): self
    {
        $this->dossierRecu = $dossierRecu;

        return $this;
    }
}
