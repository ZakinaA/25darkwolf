<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

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

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Professeur::class, cascade: ['persist', 'remove'])]
private ?Professeur $professeur = null;

public function getProfesseur(): ?Professeur
{
    return $this->professeur;
}

public function setProfesseur(?Professeur $professeur): static
{
    // set the owning side of the relation if necessary
    if ($professeur && $professeur->getUser() !== $this) {
        $professeur->setUser($this);
    }

    $this->professeur = $professeur;

    return $this;
}

#[ORM\OneToOne(mappedBy: 'user', targetEntity: Eleve::class, cascade: ['persist', 'remove'])]
private ?Eleve $eleve = null;

public function getEleve(): ?Eleve
{
    return $this->eleve;
}

public function setEleve(?Eleve $eleve): static
{
    // set the owning side of the relation if necessary
    if ($eleve && $eleve->getUser() !== $this) {
        $eleve->setUser($this);
    }

    $this->eleve = $eleve;

    return $this;
}

#[ORM\OneToOne(mappedBy: 'user', targetEntity: Admin::class, cascade: ['persist', 'remove'])]
private ?Admin $admin = null;

public function getAdmin(): ?Admin
{
    return $this->admin;
}

public function setAdmin(?Admin $admin): static
{
    // set the owning side of the relation if necessary
    if ($admin && $admin->getUser() !== $this) {
        $admin->setUser($this);
    }

    $this->admin = $admin;

    return $this;
}

#[ORM\OneToOne(mappedBy: 'user', targetEntity: Gestionnaire::class, cascade: ['persist', 'remove'])]
private ?Gestionnaire $gestionnaire = null;

public function getGestionnaire(): ?Gestionnaire
{
    return $this->gestionnaire;
}

public function setGestionnaire(?Gestionnaire $gestionnaire): static
{
    if ($gestionnaire && $gestionnaire->getUser() !== $this) {
        $gestionnaire->setUser($this);
    }

    $this->gestionnaire = $gestionnaire;

    return $this;
}

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    
}
