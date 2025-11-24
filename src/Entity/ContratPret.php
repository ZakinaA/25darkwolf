<?php

namespace App\Entity;

use App\Repository\ContratPretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratPretRepository::class)]
class ContratPret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numContrat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $etatDetailleDebut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatDetailleRetour = null;

    #[ORM\Column]
    private ?bool $attestationAssurance = null;

    // ATTENTION: La propriété $dateRetourReel a été retirée, 
    // car elle n'existe pas en base de données.
    
    // RELATION AVEC ELEVE (MANY TO ONE)
    #[ORM\ManyToOne(inversedBy: 'contratsPret')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $eleve = null;
    
    // NOUVELLE RELATION AVEC INSTRUMENT (MANY TO ONE) - CORRECTION DE L'ERREUR SÉMANTIQUE
    #[ORM\ManyToOne(inversedBy: 'contratsPret')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instrument $instrument = null;

    // RELATION AVEC INTERVENTION (ONE TO MANY)
    #[ORM\OneToMany(targetEntity: Intervention::class, mappedBy: 'contratsPret', orphanRemoval: true)]
    private Collection $interventions;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumContrat(): ?string
    {
        return $this->numContrat;
    }

    public function setNumContrat(string $numContrat): static
    {
        $this->numContrat = $numContrat;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    // ACCESSEURS POUR dateFin
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getEtatDetailleDebut(): ?string
    {
        return $this->etatDetailleDebut;
    }

    public function setEtatDetailleDebut(string $etatDetailleDebut): static
    {
        $this->etatDetailleDebut = $etatDetailleDebut;

        return $this;
    }

    public function getEtatDetailleRetour(): ?string
    {
        return $this->etatDetailleRetour;
    }

    public function setEtatDetailleRetour(?string $etatDetailleRetour): static
    {
        $this->etatDetailleRetour = $etatDetailleRetour;

        return $this;
    }

    public function isAttestationAssurance(): ?bool
    {
        return $this->attestationAssurance;
    }

    public function setAttestationAssurance(bool $attestationAssurance): static
    {
        $this->attestationAssurance = $attestationAssurance;

        return $this;
    }
    
    // ATTENTION: Les accesseurs getDateRetourReel/setDateRetourReel ont été retirés.
    
    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }
    
    // GETTER & SETTER POUR L'INSTRUMENT
    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(?Instrument $instrument): static
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): static
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setContratPret($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): static
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getContratPret() === $this) {
                $intervention->setContratPret(null);
            }
        }

        return $this;
    }
}
