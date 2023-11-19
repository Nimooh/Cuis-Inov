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

    #[ORM\ManyToOne(inversedBy: 'IdIngr')]
    private ?Allergene $idAller = null;

    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'IdIngr')]
    private Collection $IdRecette;

    public function __construct()
    {
        $this->IdRecette = new ArrayCollection();
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

    public function getIdRecette(): ?Recette
    {
        return $this->IdRecette;
    }

    public function setIdRecette(?Recette $IdRecette): static
    {
        $this->IdRecette = $IdRecette;

        return $this;
    }

    public function getIdAller(): ?Allergene
    {
        return $this->idAller;
    }

    public function setIdAller(?Allergene $idAller): static
    {
        $this->idAller = $idAller;

        return $this;
    }

    public function addIdRecette(Recette $idRecette): static
    {
        if (!$this->IdRecette->contains($idRecette)) {
            $this->IdRecette->add($idRecette);
            $idRecette->addIdIngr($this);
        }

        return $this;
    }

    public function removeIdRecette(Recette $idRecette): static
    {
        if ($this->IdRecette->removeElement($idRecette)) {
            $idRecette->removeIdIngr($this);
        }

        return $this;
    }
}
