<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nomproduit = null;

    #[ORM\Column(length: 255)]
    private ?string $Prixproduit = null;

    #[ORM\Column(length: 255)]
    private ?string $Imageproduit = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $Quantiteproduit = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $Ancienprix = null;

    #[ORM\Column(length: 255)]
    private ?string $Descriptioncourte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Section = null;

    #[ORM\Column(nullable: true)]
    private ?bool $toproduit = null;

    #[ORM\Column(nullable: true)]
    private ?bool $populaire = null;

    #[ORM\Column]
    private ?bool $isvedette = false;


    #[ORM\Column(nullable: true)]
    private ?bool $promotion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomproduit(): ?string
    {
        return $this->Nomproduit;
    }

    public function setNomproduit(string $Nomproduit): self
    {
        $this->Nomproduit = $Nomproduit;

        return $this;
    }

    public function getPrixproduit(): ?string
    {
        return $this->Prixproduit;
    }

    public function setPrixproduit(string $Prixproduit): self
    {
        $this->Prixproduit = $Prixproduit;

        return $this;
    }

    public function getImageproduit(): ?string
    {
        return $this->Imageproduit;
    }

    public function setImageproduit(string $Imageproduit): self
    {
        $this->Imageproduit = $Imageproduit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantiteproduit(): ?string
    {
        return $this->Quantiteproduit;
    }

    public function setQuantiteproduit(string $Quantiteproduit): self
    {
        $this->Quantiteproduit = $Quantiteproduit;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAncienprix(): ?string
    {
        return $this->Ancienprix;
    }

    public function setAncienprix(string $Ancienprix): self
    {
        $this->Ancienprix = $Ancienprix;

        return $this;
    }

    public function getDescriptioncourte(): ?string
    {
        return $this->Descriptioncourte;
    }

    public function setDescriptioncourte(string $Descriptioncourte): self
    {
        $this->Descriptioncourte = $Descriptioncourte;

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->Section;
    }

    public function setSection(?string $Section): self
    {
        $this->Section = $Section;

        return $this;
    }

    public function isToproduit(): ?bool
    {
        return $this->toproduit;
    }

    public function setToproduit(?bool $toproduit): static
    {
        $this->toproduit = $toproduit;

        return $this;
    }

    public function isPopulaire(): ?bool
    {
        return $this->populaire;
    }

    public function setPopulaire(?bool $populaire): static
    {
        $this->populaire = $populaire;

        return $this;
    }

    public function isPromotion(): ?bool
    {
        return $this->promotion;
    }

    public function setPromotion(?bool $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function isIsvedette(): ?bool
    {
        return $this->isvedette;
    }

    public function setIsvedette(bool $isvedette): static
    {
        $this->isvedette = $isvedette;

        return $this;
    }

    public function getLier(): ?string
    {
        return $this->lier;
    }

    public function setLier(?string $lier): static
    {
        $this->lier = $lier;

        return $this;
    }
}
