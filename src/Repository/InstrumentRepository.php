<?php

namespace App\Repository;

use App\Entity\Instrument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Instrument>
 *
 * @method Instrument|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instrument|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instrument[]    findAll()
 * @method Instrument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstrumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instrument::class);
    }
    
    /**
     * Récupère tous les instruments en chargeant les relations nécessaires.
     * La jointure 'marque' a été retirée temporairement pour corriger l'erreur sémantique.
     * @return Instrument[] Returns an array of Instrument objects
     */
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('i')
            // Jointure vers le TypeInstrument (nécessaire pour l'affichage dans index.html.twig)
            ->leftJoin('i.typeInstrument', 'ti')
            ->addSelect('ti')
            
            // JOINTURE MARQUE RETIRÉE POUR ÉVITER L'ERREUR SÉMANTIQUE :
            // Si la relation n'est pas définie dans Instrument.php, cette jointure échoue.
            /*
            ->leftJoin('i.marque', 'm')
            ->addSelect('m')
            */
            
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
