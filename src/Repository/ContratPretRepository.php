<?php

namespace App\Repository;

use App\Entity\ContratPret;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContratPret>
 *
 * @method ContratPret|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratPret|null findOneBy(array $criteria, array array $orderBy = null)
 * @method ContratPret[]    findAll()
 * @method ContratPret[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratPretRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratPret::class);
    }

    /**
     * Récupère tous les contrats de prêt en chargeant l'Élève et l'Instrument.
     * C'est la nouvelle méthode optimisée pour la page index.
     * @return ContratPret[] Returns an array of ContratPret objects
     */
    public function findAllForIndex(): array
    {
        return $this->createQueryBuilder('cp')
            // Jointure pour l'Élève
            ->innerJoin('cp.eleve', 'e')
            ->addSelect('e') 
            
            // Jointure pour l'Instrument (J'assume que la propriété est 'instrument' dans ContratPret)
            ->innerJoin('cp.instrument', 'inst') 
            ->addSelect('inst')
            
            // Jointure pour le Type d'Instrument (pour l'affichage du libellé)
            ->innerJoin('inst.typeInstrument', 'ti')
            ->addSelect('ti')

            ->orderBy('cp.dateDebut', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    // --- Les autres méthodes de votre Repository sont conservées ci-dessous ---

    /**
     * @deprecated Cette méthode est moins performante pour l'index, utilisez findAllForIndex()
     */
    public function findAllWithEleve(): array
    {
        return $this->createQueryBuilder('cp')
            ->innerJoin('cp.eleve', 'e')
            ->addSelect('e') 
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @deprecated Cette méthode est moins performante pour l'index, utilisez findAllForIndex()
     */
    public function findAllWithInterventions(): array
    {
        return $this->createQueryBuilder('cp')
            ->leftJoin('cp.interventions', 'i')
            ->addSelect('i')
            ->orderBy('cp.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByIdWithAllRelations(int $id): ?ContratPret
    {
        return $this->createQueryBuilder('cp')
            ->innerJoin('cp.eleve', 'e')->addSelect('e')
            ->leftJoin('cp.interventions', 'i')->addSelect('i')
            ->leftJoin('cp.instrument', 'inst')->addSelect('inst') // Ajout de l'instrument dans la vue show
            ->andWhere('cp.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}