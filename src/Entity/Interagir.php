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
    private ?bool $fav = false;

    #[ORM\Column(nullable: true)]
    private ?int $noteRecette = null;

    #[ORM\ManyToOne(inversedBy: 'interagirs')]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'interagirs')]
    private ?Recette $recette = null;

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

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): static
    {
        $this->membre = $membre;

        return $this;
    }

    public function getRecette(): ?Recette
    {
        return $this->recette;
    }

    public function setRecette(?Recette $recette): static
    {
        $this->recette = $recette;

        return $this;
    }

    public function getNoteRecette(): ?int
    {
        return $this->noteRecette;
    }

    public function setNoteRecette(int $noteRecette): static
    {
        $this->noteRecette = $noteRecette;

        return $this;
    }
}
