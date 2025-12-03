<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 *
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    /**
     * Récupère tous les Cours, triés manuellement par l'ordre des jours et ensuite par l'heure de début.
     * C'est la méthode la plus fiable pour le planning global.
     * @return Cours[] Returns an array of Cours objects
     */
    public function findAllOrderedByTime(): array
    {
        // Ordre des jours pour le tri manuel
        // Assurez-vous que l'entité Jour a bien une méthode getLibelle()
        $dayOrder = [
            'Lundi' => 1, 
            'Mardi' => 2, 
            'Mercredi' => 3, 
            'Jeudi' => 4, 
            'Vendredi' => 5, 
            'Samedi' => 6, 
            'Dimanche' => 7,
            'Inconnu' => 99, // Pour les cours sans jour
        ];

        // 1. Récupérer tous les cours avec les relations Jour et Professeur chargées
        $cours = $this->createQueryBuilder('c')
            ->leftJoin('c.jour', 'j')->addSelect('j')
            ->leftJoin('c.professeur', 'p')->addSelect('p')
            // Tri initial par heure de début
            ->orderBy('c.heureDebut', 'ASC') 
            ->getQuery()
            ->getResult();

        // 2. Tri manuel en PHP pour garantir l'ordre Lundi, Mardi, Mercredi...
        usort($cours, function (Cours $a, Cours $b) use ($dayOrder) {
            
            $jourA = $a->getJour() ? $a->getJour()->getLibelle() : 'Inconnu';
            $jourB = $b->getJour() ? $b->getJour()->getLibelle() : 'Inconnu';
            
            $dayRankA = $dayOrder[$jourA] ?? 99;
            $dayRankB = $dayOrder[$jourB] ?? 99;

            // Comparaison principale : par jour
            if ($dayRankA !== $dayRankB) {
                return $dayRankA <=> $dayRankB;
            }

            // Comparaison secondaire (si les jours sont les mêmes) : par heure de début
            return $a->getHeureDebut() <=> $b->getHeureDebut();
        });

        return $cours;
    }

    /**
     * Récupère les cours associés à un élève via ses inscriptions (table de jointure).
     * @return Cours[]
     */
    public function findCoursByEleve(int $eleveId): array
    {
        return $this->createQueryBuilder('c')
            // Jointure sur la collection 'inscription' si elle existe dans Cours, ou via l'entité Inscription
            ->innerJoin('App\Entity\Inscription', 'i', 'WITH', 'i.cours = c')
            ->andWhere('i.eleve = :eleveId')
            ->setParameter('eleveId', $eleveId)
            // On peut s'appuyer sur le tri BDD ici, même si l'ordre exact Lundi-Dimanche n'est pas garanti.
            ->leftJoin('c.jour', 'j')
            ->orderBy('j.id', 'ASC') 
            ->addOrderBy('c.heureDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les cours dispensés par un professeur spécifique.
     * @return Cours[]
     */
    public function findCoursByProfesseur(int $professeurId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.professeur = :profId')
            ->setParameter('profId', $professeurId)
            // Tri par jour puis par heure de début
            ->leftJoin('c.jour', 'j') 
            ->orderBy('j.id', 'ASC') 
            ->addOrderBy('c.heureDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
}