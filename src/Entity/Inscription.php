<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Cette colonne correspond à votre colonne existante en BDD.
     * Elle est maintenant initialisée automatiquement avec la date du jour.
     * * NOTE: Puisque la BDD la définit probablement en type DATE (pas DATETIME), 
     * l'heure sera ignorée, mais la date sera toujours celle du moment de l'inscription.
     */
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateInscrption = null; 

    #[ORM\ManyToOne(inversedBy: 'inscription')]
    private ?Eleve $eleve = null;

    #[ORM\ManyToOne(inversedBy: 'inscription')]
    private ?Cours $cours = null;

    /**
     * @var Collection<int, Paiement>
     */
    #[ORM\OneToMany(targetEntity: Paiement::class, mappedBy: 'inscription', orphanRemoval: true, cascade: ['remove'])]
    private Collection $paiements;

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        // Initialisation automatique de la date du jour pour l'inscription
        $this->dateInscrption = new \DateTime(); 
    }

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

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setInscription($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getInscription() === $this) {
                $paiement->setInscription(null);
            }
        }

        return $this;
    }
}