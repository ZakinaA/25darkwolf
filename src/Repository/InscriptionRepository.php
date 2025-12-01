<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Eleve; // <-- AJOUT CRUCIAL
use App\Entity\Cours; // <-- AJOUT CRUCIAL

/**
 * @extends ServiceEntityRepository<Inscription>
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

    public function findInscriptionByEleveAndCours(Eleve $eleve, Cours $cours): ?Inscription
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.eleve = :eleve')
            ->setParameter('eleve', $eleve)
            // <-- CORRECTION ICI : 'i.cour' remplacé par 'i.cours' (le nom de la propriété dans l'entité)
            ->andWhere('i.cours = :cours') 
            ->setParameter('cours', $cours)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Inscription[] Returns an array of Inscription objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Inscription
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
