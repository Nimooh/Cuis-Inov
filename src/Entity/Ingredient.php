<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $nomIngr = null;

    #[ORM\Column]
    private ?float $qteIngr = null;

    #[ORM\Column(length: 255)]
    private ?string $unite = null;

    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'ingredients')]
    private Collection $recettes;

    #[ORM\ManyToMany(targetEntity: Allergene::class, inversedBy: 'ingredients')]
    private Collection $allergenes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
        $this->allergenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $recette->addIngredient($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeIngredient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Allergene>
     */
    public function getAllergenes(): Collection
    {
        return $this->allergenes;
    }

    public function addAllergene(Allergene $allergene): static
    {
        if (!$this->allergenes->contains($allergene)) {
            $this->allergenes->add($allergene);
        }

        return $this;
    }

    public function removeAllergene(Allergene $allergene): static
    {
        $this->allergenes->removeElement($allergene);

        return $this;
    }

}
