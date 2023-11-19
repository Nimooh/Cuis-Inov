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
    private $imgRecette = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instruction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'IdRecette')]
    private ?Interagir $IdInteragir = null;

    #[ORM\ManyToOne(inversedBy: 'IdRecette')]
    private Collection $IdCatRecette;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'IdRecette')]
    private Collection $IdIngr;

    public function __construct()
    {
        $this->IdCatRecette = new ArrayCollection();
        $this->IdIngr = new ArrayCollection();
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

    public function getIdInteragir(): ?Interagir
    {
        return $this->IdInteragir;
    }

    public function setIdInteragir(?Interagir $IdInteragir): static
    {
        $this->IdInteragir = $IdInteragir;

        return $this;
    }

    /**
     * @return Collection<int, CategorieRecette>
     */
    public function getIdCatRecette(): Collection
    {
        return $this->IdCatRecette;
    }

    public function addIdCatRecette(CategorieRecette $idCatRecette): static
    {
        if (!$this->IdCatRecette->contains($idCatRecette)) {
            $this->IdCatRecette->add($idCatRecette);
            $idCatRecette->setIdRecette($this);
        }

        return $this;
    }

    public function removeIdCatRecette(CategorieRecette $idCatRecette): static
    {
        if ($this->IdCatRecette->removeElement($idCatRecette)) {
            // set the owning side to null (unless already changed)
            if ($idCatRecette->getIdRecette() === $this) {
                $idCatRecette->setIdRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIdIngr(): Collection
    {
        return $this->IdIngr;
    }

    public function addIdIngr(Ingredient $idIngr): static
    {
        if (!$this->IdIngr->contains($idIngr)) {
            $this->IdIngr->add($idIngr);
            $idIngr->setIdRecette($this);
        }

        return $this;
    }

    public function removeIdIngr(Ingredient $idIngr): static
    {
        if ($this->IdIngr->removeElement($idIngr)) {
            // set the owning side to null (unless already changed)
            if ($idIngr->getIdRecette() === $this) {
                $idIngr->setIdRecette(null);
            }
        }

        return $this;
    }
}
