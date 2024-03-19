<?php

namespace App\Entity;

use App\Repository\TopventeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopventeRepository::class)]
class Topvente
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
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $Imageproduit = null;

    #[ORM\Column(length: 255)]
    private ?string $Ancienprix = null;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

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

    public function getAncienprix(): ?string
    {
        return $this->Ancienprix;
    }

    public function setAncienprix(string $Ancienprix): self
    {
        $this->Ancienprix = $Ancienprix;

        return $this;
    }
}
