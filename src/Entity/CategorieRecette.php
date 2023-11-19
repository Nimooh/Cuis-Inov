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

    #[ORM\OneToMany(mappedBy: 'IdRecette', targetEntity: CategorieRecette::class)]
    private ?Recette $IdRecette = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdRecette(): ?Recette
    {
        return $this->IdRecette;
    }

    public function setIdRecette(?Recette $IdRecette): static
    {
        $this->IdRecette = $IdRecette;

        return $this;
    }
}
