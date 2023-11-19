<?php

namespace App\Entity;

use App\Repository\AllergeneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'idAller', targetEntity: Ingredient::class)]
    private Collection $IdIngr;

    public function __construct()
    {
        $this->IdIngr = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIdIngr(): Collection
    {
        return $this->IdIngr;
    }

    public function addIdIngr(Ingredient $idIngr): static
    {
        if (!$this->IdIngr->contains($idIngr)) {
            $this->IdIngr->add($idIngr);
            $idIngr->setIdAller($this);
        }

        return $this;
    }

    public function removeIdIngr(Ingredient $idIngr): static
    {
        if ($this->IdIngr->removeElement($idIngr)) {
            // set the owning side to null (unless already changed)
            if ($idIngr->getIdAller() === $this) {
                $idIngr->setIdAller(null);
            }
        }

        return $this;
    }
}
