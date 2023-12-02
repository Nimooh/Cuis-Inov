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

    #[ORM\Column]
    private ?int $diffRecette = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgRecette = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instruction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: CategorieRecette::class, inversedBy: 'recettes')]
    private Collection $categoriesRecette;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Interagir::class)]
    private Collection $interagirs;

    #[ORM\Column]
    private ?float $noteMoyenne = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Composer::class)]
    private Collection $composers;

    public function __construct()
    {
        $this->categoriesRecette = new ArrayCollection();
        $this->interagirs = new ArrayCollection();
        $this->composers = new ArrayCollection();
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
     * @return Collection<int, Interagir>
     */
    public function getInteragirs(): Collection
    {
        return $this->interagirs;
    }

    public function addInteragir(Interagir $interagir): static
    {
        if (!$this->interagirs->contains($interagir)) {
            $this->interagirs->add($interagir);
            $interagir->setRecette($this);
        }

        return $this;
    }

    public function removeInteragir(Interagir $interagir): static
    {
        if ($this->interagirs->removeElement($interagir)) {
            // set the owning side to null (unless already changed)
            if ($interagir->getRecette() === $this) {
                $interagir->setRecette(null);
            }
        }

        return $this;
    }

    public function getNoteMoyenne(): ?float
    {
        return $this->noteMoyenne;
    }

    public function setNoteMoyenne(float $noteMoyenne): static
    {
        $this->noteMoyenne = $noteMoyenne;

        return $this;
    }

    /**
     * @return Collection<int, Composer>
     */
    public function getComposers(): Collection
    {
        return $this->composers;
    }

    public function addComposer(Composer $composer): static
    {
        if (!$this->composers->contains($composer)) {
            $this->composers->add($composer);
            $composer->setRecette($this);
        }

        return $this;
    }

    public function removeComposer(Composer $composer): static
    {
        if ($this->composers->removeElement($composer)) {
            // set the owning side to null (unless already changed)
            if ($composer->getRecette() === $this) {
                $composer->setRecette(null);
            }
        }

        return $this;
    }

}
