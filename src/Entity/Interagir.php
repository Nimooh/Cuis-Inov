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

    #[ORM\ManyToOne(inversedBy: 'IdInteragir')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $idInteragir = null;

    #[ORM\ManyToOne(inversedBy: 'idInteragir')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recette $idRecette = null;

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

    public function getIdInteragir(): ?Membre
    {
        return $this->idInteragir;
    }

    public function setIdInteragir(?Membre $idInteragir): static
    {
        $this->idInteragir = $idInteragir;

        return $this;
    }

    public function getIdRecette(): ?Recette
    {
        return $this->idRecette;
    }

    public function setIdRecette(?Recette $idRecette): static
    {
        $this->idRecette = $idRecette;

        return $this;
    }
}
