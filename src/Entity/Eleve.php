<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $numRue = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $rue = null;

    #[ORM\Column(nullable: true)]
    private ?int $copos = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(nullable: true)]
    private ?int $tel = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $mail = null;

    /**
     * @var Collection<int, Responsable>
     */
    #[ORM\ManyToMany(targetEntity: Responsable::class, inversedBy: 'eleves')]
    private Collection $responsable;

    #[ORM\ManyToOne(inversedBy: 'eleves')]
    private ?Tranche $tranche = null;

    public function __construct()
    {
        $this->responsable = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumRue(): ?int
    {
        return $this->numRue;
    }

    public function setNumRue(?int $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCopos(): ?int
    {
        return $this->copos;
    }

    public function setCopos(?int $copos): static
    {
        $this->copos = $copos;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(?int $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Responsable>
     */
    public function getResponsable(): Collection
    {
        return $this->responsable;
    }

    public function addResponsable(Responsable $responsable): static
    {
        if (!$this->responsable->contains($responsable)) {
            $this->responsable->add($responsable);
        }

        return $this;
    }

    public function removeResponsable(Responsable $responsable): static
    {
        $this->responsable->removeElement($responsable);

        return $this;
    }

    public function getTranche(): ?Tranche
    {
        return $this->tranche;
    }

    public function setTranche(?Tranche $tranche): static
    {
        $this->tranche = $tranche;

        return $this;
    }
}
