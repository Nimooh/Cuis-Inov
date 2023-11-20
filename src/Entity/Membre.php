<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nomMembre = null;

    #[ORM\Column(length: 255)]
    private ?string $prnmMembre = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imgProfilMembre;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $CPMembre = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $adrMembre = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $villeMembre = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $telMembre = null;

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

    public function getImgProfilMembre()
    {
        return $this->imgProfilMembre;
    }

    public function setImgProfilMembre($imgProfilMembre): static
    {
        $this->imgProfilMembre = $imgProfilMembre;

        return $this;
    }

    public function getCPMembre(): ?string
    {
        return $this->CPMembre;
    }

    public function setCPMembre(?string $CPMembre): static
    {
        $this->CPMembre = $CPMembre;

        return $this;
    }

    public function getAdrMembre(): ?string
    {
        return $this->adrMembre;
    }

    public function setAdrMembre(?string $adrMembre): static
    {
        $this->adrMembre = $adrMembre;

        return $this;
    }

    public function getVilleMembre(): ?string
    {
        return $this->villeMembre;
    }

    public function setVilleMembre(?string $villeMembre): static
    {
        $this->villeMembre = $villeMembre;

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
}
