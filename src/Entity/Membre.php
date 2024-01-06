<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cette email')]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Assert\Email()]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Assert\Length([
        'min' => 6,
        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
            // max length allowed by Symfony for security reasons
        'max' => 4096,
    ])]
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 30)]
    #[ORM\Column(length: 255)]
    private ?string $nomMembre = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 30)]
    #[ORM\Column(length: 255)]
    private ?string $prnmMembre = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    #[Assert\Regex(pattern: '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4})$/', message: 'Format de téléphone invalide')]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $telMembre = null;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Interagir::class)]
    private Collection $interagirs;

    #[ORM\OneToMany(mappedBy: 'Membre', targetEntity: Recette::class)]
    private Collection $recettes;

    #[ORM\ManyToMany(targetEntity: Allergene::class, inversedBy: 'membres')]
    private Collection $allergenes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->interagirs = new ArrayCollection();
        $this->recettes = new ArrayCollection();
        $this->allergenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomMembre(): ?string
    {
        return $this->nomMembre;
    }

    public function setNomMembre(string $nomMembre): static
    {
        $this->nomMembre = $nomMembre;

        return $this;
    }

    public function getPrnmMembre(): ?string
    {
        return $this->prnmMembre;
    }

    public function setPrnmMembre(string $prnmMembre): static
    {
        $this->prnmMembre = $prnmMembre;

        return $this;
    }

    public function getTelMembre(): ?string
    {
        return $this->telMembre;
    }

    public function setTelMembre(?string $telMembre): static
    {
        $this->telMembre = $telMembre;

        return $this;
    }

    /**
     * @return Collection<int, Interagir>
     */
    public function getInteragirs(): Collection
    {
        return $this->interagirs;
    }

    public function addInteragir(Interagir $interagir): static
    {
        if (!$this->interagirs->contains($interagir)) {
            $this->interagirs->add($interagir);
            $interagir->setMembre($this);
        }

        return $this;
    }

    public function removeInteragir(Interagir $interagir): static
    {
        if ($this->interagirs->removeElement($interagir)) {
            // set the owning side to null (unless already changed)
            if ($interagir->getMembre() === $this) {
                $interagir->setMembre(null);
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
            $recette->setMembre($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getMembre() === $this) {
                $recette->setMembre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Allergene>
     */
    public function getAllergenes(): Collection
    {
        return $this->allergenes;
    }

    public function addAllergene(Allergene $allergene): static
    {
        if (!$this->allergenes->contains($allergene)) {
            $this->allergenes->add($allergene);
        }

        return $this;
    }

    public function removeAllergene(Allergene $allergene): static
    {
        $this->allergenes->removeElement($allergene);

        return $this;
    }
}
