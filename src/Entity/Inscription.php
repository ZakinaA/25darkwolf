<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateInscrption = null;

    #[ORM\ManyToOne(inversedBy: 'inscription')]
    private ?Eleve $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'inscription')]
    private ?Cours $cours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscrption(): ?\DateTime
    {
        return $this->dateInscrption;
    }

    public function setDateInscrption(?\DateTime $dateInscrption): static
    {
        $this->dateInscrption = $dateInscrption;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): static
    {
        $this->cours = $cours;

        return $this;
    }
}
