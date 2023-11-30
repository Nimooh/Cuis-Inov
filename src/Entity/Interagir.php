<?php

namespace App\Entity;

use App\Repository\InteragirRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InteragirRepository::class)]
class Interagir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $fav = null;

    #[ORM\OneToMany(mappedBy: 'interagir', targetEntity: Membre::class)]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: 'interagir', targetEntity: Recette::class)]
    private Collection $recettes;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isFav(): ?bool
    {
        return $this->fav;
    }

    public function setFav(?bool $fav): static
    {
        $this->fav = $fav;

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setInteragir($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getInteragir() === $this) {
                $membre->setInteragir(null);
            }
        }

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
            $recette->setInteragir($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getInteragir() === $this) {
                $recette->setInteragir(null);
            }
        }

        return $this;
    }
}
