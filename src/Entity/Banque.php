<?php

namespace App\Entity;

use App\Repository\BanqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BanqueRepository::class)]
class Banque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $desti = null;

    #[ORM\Column(length: 255)]
    private ?string $banque  = null;

    #[ORM\Column(length: 255)]
    private ?string $bic = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDesti(): ?string
    {
        return $this->desti;
    }

    public function setDesti(string $desti): self
    {
        $this->desti = $desti;

        return $this;
    }

    public function getBanque(): ?string
    {
        return $this->banque;
    }

    public function setBanque(string $banque): self
    {
        $this->banque = $banque;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setPays(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }
}
