<?php

namespace App\Entity;

use App\Repository\CategorieRecetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRecetteRepository::class)]
class CategorieRecette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCatRecette = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCatRecette(): ?int
    {
        return $this->idCatRecette;
    }

    public function setIdCatRecette(int $idCatRecette): static
    {
        $this->idCatRecette = $idCatRecette;

        return $this;
    }

    public function getNomCatRecette(): ?string
    {
        return $this->nomCatRecette;
    }

    public function setNomCatRecette(string $nomCatRecette): static
    {
        $this->nomCatRecette = $nomCatRecette;

        return $this;
    }
}
