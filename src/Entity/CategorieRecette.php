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

    #[ORM\OneToMany(mappedBy: 'idCatRecette', targetEntity: Recette::class)]
    private Collection $idRecette;

    public function __construct()
    {
        $this->idRecette = new ArrayCollection();
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
    public function getIdRecette(): Collection
    {
        return $this->idRecette;
    }

    public function addIdRecette(Recette $idRecette): static
    {
        if (!$this->idRecette->contains($idRecette)) {
            $this->idRecette->add($idRecette);
            $idRecette->setIdCatRecette($this);
        }

        return $this;
    }

    public function removeIdRecette(Recette $idRecette): static
    {
        if ($this->idRecette->removeElement($idRecette)) {
            // set the owning side to null (unless already changed)
            if ($idRecette->getIdCatRecette() === $this) {
                $idRecette->setIdCatRecette(null);
            }
        }

        return $this;
    }
}
