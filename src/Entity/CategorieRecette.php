<?php

namespace App\Entity;

use App\Repository\CategorieRecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'categoriesRecette')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->addCategoriesRecette($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeCategoriesRecette($this);
        }

        return $this;
    }

}
