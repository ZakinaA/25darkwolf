<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    /**
     * Récupère les cours associés à un élève spécifique via la table Inscription.
     *
     * @param int $eleveId L'identifiant de l'élève
     * @return Cours[] Retourne un tableau d'objets Cours
     */
    public function findByEleve($eleveId): array
    {
        return $this->createQueryBuilder('c')
            // On joint l'entité Inscription (i) explicitement
            // La condition 'WITH' assure qu'on lie l'inscription au cours actuel (c)
            ->innerJoin('App\Entity\Inscription', 'i', 'WITH', 'i.cours = c')
            
            // On filtre pour ne garder que les inscriptions de l'élève demandé
            ->andWhere('i.eleve = :val')
            ->setParameter('val', $eleveId)
            
            // Tri : D'abord par jour (Lundi, Mardi...), puis par heure de cours
            ->orderBy('c.jour', 'ASC')
            ->addOrderBy('c.heureDebut', 'ASC')
            
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Cours[] Returns an array of Cours objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cours
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}