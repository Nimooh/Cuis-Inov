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

    #[ORM\OneToMany(mappedBy: 'idRecette', targetEntity: Interagir::class)]
    private Collection $idInteragir;

    #[ORM\ManyToOne(inversedBy: 'idRecette')]
    private ?CategorieRecette $idCatRecette = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'idRecette')]
    private Collection $idIngr;

    public function __construct()
    {
        $this->idInteragir = new ArrayCollection();
        $this->idIngr = new ArrayCollection();
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

    /**
     * @return Collection<int, Interagir>
     */
    public function getIdInteragir(): Collection
    {
        return $this->idInteragir;
    }

    public function addIdInteragir(Interagir $idInteragir): static
    {
        if (!$this->idInteragir->contains($idInteragir)) {
            $this->idInteragir->add($idInteragir);
            $idInteragir->setIdRecette($this);
        }

        return $this;
    }

    public function removeIdInteragir(Interagir $idInteragir): static
    {
        if ($this->idInteragir->removeElement($idInteragir)) {
            // set the owning side to null (unless already changed)
            if ($idInteragir->getIdRecette() === $this) {
                $idInteragir->setIdRecette(null);
            }
        }

        return $this;
    }

    public function getIdCatRecette(): ?CategorieRecette
    {
        return $this->idCatRecette;
    }

    public function setIdCatRecette(?CategorieRecette $idCatRecette): static
    {
        $this->idCatRecette = $idCatRecette;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIdIngr(): Collection
    {
        return $this->idIngr;
    }

    public function addIdIngr(Ingredient $idIngr): static
    {
        if (!$this->idIngr->contains($idIngr)) {
            $this->idIngr->add($idIngr);
        }

        return $this;
    }

    public function removeIdIngr(Ingredient $idIngr): static
    {
        $this->idIngr->removeElement($idIngr);

        return $this;
    }
}
