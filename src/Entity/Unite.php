<?php

namespace App\Entity;

use App\Repository\UniteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniteRepository::class)]
class Unite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomUnit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUnit(): ?string
    {
        return $this->nomUnit;
    }

    public function setNomUnit(string $nomUnit): static
    {
        $this->nomUnit = $nomUnit;

        return $this;
    }
}
