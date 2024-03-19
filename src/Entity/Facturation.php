<?php

namespace App\Entity;

use App\Repository\FacturationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturationRepository::class)]
class Facturation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $produit = null;

    #[ORM\Column(length: 255)]
    private ?string $Prix_totale = null;

    #[ORM\Column(length: 255)]
    private ?string $Typepaiement = null;

    #[ORM\Column(length: 255)]
    private ?string $quantite = null;

    #[ORM\Column(length: 255)]
    private ?string $adresselivraison = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $Tel = null;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = 'En attente';

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\OneToMany(targetEntity: ProduitAcheter::class, mappedBy: 'facture')]
    private Collection $produitAcheters;

    public function __construct()
    {
        $this->produitAcheters = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getPrixTotale(): ?string
    {
        return $this->Prix_totale;
    }

    public function setPrixTotale(string $Prix_totale): self
    {
        $this->Prix_totale = $Prix_totale;

        return $this;
    }

    public function getTypepaiement(): ?string
    {
        return $this->Typepaiement;
    }

    public function setTypepaiement(string $Typepaiement): self
    {
        $this->Typepaiement = $Typepaiement;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getAdresselivraison(): ?string
    {
        return $this->adresselivraison;
    }

    public function setAdresselivraison(string $adresselivraison): self
    {
        $this->adresselivraison = $adresselivraison;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

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

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getProduitAcheter(): ?ProduitAcheter
    {
        return $this->produitAcheter;
    }

    public function setProduitAcheter(?ProduitAcheter $produitAcheter): static
    {
        $this->produitAcheter = $produitAcheter;

        return $this;
    }

    /**
     * @return Collection<int, ProduitAcheter>
     */
    public function getProduitAcheters(): Collection
    {
        return $this->produitAcheters;
    }

    public function addProduitAcheter(ProduitAcheter $produitAcheter): static
    {
        if (!$this->produitAcheters->contains($produitAcheter)) {
            $this->produitAcheters->add($produitAcheter);
            $produitAcheter->setFacture($this);
        }

        return $this;
    }

    public function removeProduitAcheter(ProduitAcheter $produitAcheter): static
    {
        if ($this->produitAcheters->removeElement($produitAcheter)) {
            // set the owning side to null (unless already changed)
            if ($produitAcheter->getFacture() === $this) {
                $produitAcheter->setFacture(null);
            }
        }

        return $this;
    }
}
