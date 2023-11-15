<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idIngr = null;

    #[ORM\Column(length: 255)]
    private ?string $nomIngr = null;

    #[ORM\Column]
    private ?float $qteIngr = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdIngr(): ?int
    {
        return $this->idIngr;
    }

    public function setIdIngr(int $idIngr): static
    {
        $this->idIngr = $idIngr;

        return $this;
    }

    public function getNomIngr(): ?string
    {
        return $this->nomIngr;
    }

    public function setNomIngr(string $nomIngr): static
    {
        $this->nomIngr = $nomIngr;

        return $this;
    }

    public function getQteIngr(): ?float
    {
        return $this->qteIngr;
    }

    public function setQteIngr(float $qteIngr): static
    {
        $this->qteIngr = $qteIngr;

        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;

        return $this;
    }
}
