<?php

namespace App\Entity;

use App\Repository\InteragirRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'fav', targetEntity: Membre::class)]
    private Collection $IdMembre;

    #[ORM\OneToMany(mappedBy: 'IdInteragir', targetEntity: Recette::class)]
    private Collection $IdRecette;

    public function __construct()
    {
        $this->IdMembre = new ArrayCollection();
        $this->IdRecette = new ArrayCollection();
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
    public function getIdMembre(): Collection
    {
        return $this->IdMembre;
    }

    public function addIdMembre(Membre $idMembre): static
    {
        if (!$this->IdMembre->contains($idMembre)) {
            $this->IdMembre->add($idMembre);
            $idMembre->setFav($this);
        }

        return $this;
    }

    public function removeIdMembre(Membre $idMembre): static
    {
        if ($this->IdMembre->removeElement($idMembre)) {
            // set the owning side to null (unless already changed)
            if ($idMembre->getFav() === $this) {
                $idMembre->setFav(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getIdRecette(): Collection
    {
        return $this->IdRecette;
    }

    public function addIdRecette(Recette $idRecette): static
    {
        if (!$this->IdRecette->contains($idRecette)) {
            $this->IdRecette->add($idRecette);
            $idRecette->setIdInteragir($this);
        }

        return $this;
    }

    public function removeIdRecette(Recette $idRecette): static
    {
        if ($this->IdRecette->removeElement($idRecette)) {
            // set the owning side to null (unless already changed)
            if ($idRecette->getIdInteragir() === $this) {
                $idRecette->setIdInteragir(null);
            }
        }

        return $this;
    }
}
