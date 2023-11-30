<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomRecette = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $tempsRecette = null;

    #[ORM\Column(nullable: true)]
    private ?float $starsRecette = null;

    #[ORM\Column]
    private ?int $diffRecette = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgRecette;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instruction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Interagir $interagir = null;

    #[ORM\ManyToMany(targetEntity: CategorieRecette::class, inversedBy: 'recettes')]
    private Collection $categoriesRecette;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'recettes')]
    private Collection $ingredients;

    public function __construct()
    {
        $this->categoriesRecette = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRecette(): ?string
    {
        return $this->nomRecette;
    }

    public function setNomRecette(string $nomRecette): static
    {
        $this->nomRecette = $nomRecette;

        return $this;
    }

    public function getTempsRecette(): ?\DateTimeInterface
    {
        return $this->tempsRecette;
    }

    public function setTempsRecette(?\DateTimeInterface $tempsRecette): static
    {
        $this->tempsRecette = $tempsRecette;

        return $this;
    }

    public function getStarsRecette(): ?float
    {
        return $this->starsRecette;
    }

    public function setStarsRecette(?float $starsRecette): static
    {
        $this->starsRecette = $starsRecette;

        return $this;
    }

    public function getDiffRecette(): ?string
    {
        return $this->diffRecette;
    }

    public function setDiffRecette(?string $diffRecette): static
    {
        $this->diffRecette = $diffRecette;

        return $this;
    }

    public function getImgRecette()
    {
        return $this->imgRecette;
    }

    public function setImgRecette($imgRecette): static
    {
        $this->imgRecette = $imgRecette;

        return $this;
    }

    public function getInstruction(): ?string
    {
        return $this->instruction;
    }

    public function setInstruction(?string $instruction): static
    {
        $this->instruction = $instruction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getInteragir(): ?Interagir
    {
        return $this->interagir;
    }

    public function setInteragir(?Interagir $interagir): static
    {
        $this->interagir = $interagir;

        return $this;
    }

    /**
     * @return Collection<int, CategorieRecette>
     */
    public function getCategoriesRecette(): Collection
    {
        return $this->categoriesRecette;
    }

    public function addCategoriesRecette(CategorieRecette $categoriesRecette): static
    {
        if (!$this->categoriesRecette->contains($categoriesRecette)) {
            $this->categoriesRecette->add($categoriesRecette);
        }

        return $this;
    }

    public function removeCategoriesRecette(CategorieRecette $categoriesRecette): static
    {
        $this->categoriesRecette->removeElement($categoriesRecette);

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

}
