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

    #[ORM\Column]
    private ?int $idInt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $fav = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdInt(): ?int
    {
        return $this->idInt;
    }

    public function setIdInt(int $idInt): static
    {
        $this->idInt = $idInt;

        return $this;
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
}
