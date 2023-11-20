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

    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'idIngr')]
    private Collection $idRecette;

    #[ORM\ManyToOne(inversedBy: 'idIngr')]
    private ?Allergene $idAller = null;

    public function __construct()
    {
        $this->idRecette = new ArrayCollection();
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
    public function getIdRecette(): Collection
    {
        return $this->idRecette;
    }

    public function addIdRecette(Recette $idRecette): static
    {
        if (!$this->idRecette->contains($idRecette)) {
            $this->idRecette->add($idRecette);
            $idRecette->addIdIngr($this);
        }

        return $this;
    }

    public function removeIdRecette(Recette $idRecette): static
    {
        if ($this->idRecette->removeElement($idRecette)) {
            $idRecette->removeIdIngr($this);
        }

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
}
