<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfosEntrepriseRepository")
 */
class InfosEntreprise
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
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $complementAdresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $horairesOuverture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephoneFixe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tva;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cnil;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeVisa;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bonDeCommande;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paiementVirement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paiementCheque;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complementAdresse;
    }

    public function setComplementAdresse(string $complementAdresse): self
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getHorairesOuverture(): ?string
    {
        return $this->horairesOuverture;
    }

    public function setHorairesOuverture(string $horairesOuverture): self
    {
        $this->horairesOuverture = $horairesOuverture;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephoneFixe(): ?string
    {
        return $this->telephoneFixe;
    }

    public function setTelephoneFixe(string $telephoneFixe): self
    {
        $this->telephoneFixe = $telephoneFixe;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getCnil(): ?string
    {
        return $this->cnil;
    }

    public function setCnil(string $cnil): self
    {
        $this->cnil = $cnil;

        return $this;
    }

    public function getTypeVisa(): ?string
    {
        return $this->typeVisa;
    }

    public function setTypeVisa(string $typeVisa): self
    {
        $this->typeVisa = $typeVisa;

        return $this;
    }

    public function getBonDeCommande(): ?string
    {
        return $this->bonDeCommande;
    }

    public function setBonDeCommande(?string $bonDeCommande): self
    {
        $this->bonDeCommande = $bonDeCommande;

        return $this;
    }

    public function getPaiementVirement(): ?string
    {
        return $this->paiementVirement;
    }

    public function setPaiementVirement(?string $paiementVirement): self
    {
        $this->paiementVirement = $paiementVirement;

        return $this;
    }

    public function getPaiementCheque(): ?string
    {
        return $this->paiementCheque;
    }

    public function setPaiementCheque(?string $paiementCheque): self
    {
        $this->paiementCheque = $paiementCheque;

        return $this;
    }
}
