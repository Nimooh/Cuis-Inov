<?php

namespace App\Entity;

use App\Repository\AllergeneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergeneRepository::class)]
class Allergene
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAller = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAller(): ?int
    {
        return $this->idAller;
    }

    public function setIdAller(int $idAller): static
    {
        $this->idAller = $idAller;

        return $this;
    }

    public function getNomAller(): ?string
    {
        return $this->nomAller;
    }

    public function setNomAller(string $nomAller): static
    {
        $this->nomAller = $nomAller;

        return $this;
    }
}
