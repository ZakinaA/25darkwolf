<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intervention>
 *
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    /**
     * Retrieves all interventions with Eager Loading for related entities (Instrument, TypeInstrument, Marque, Professionnel).
     * @return Intervention[] Returns an array of Intervention objects
     */
    public function findAllWithRelations(): array
    {
        try {
            return $this->createQueryBuilder('i')
                // Join for Instrument
                ->leftJoin('i.instrument', 'inst')
                ->addSelect('inst')
                
                // Join for TypeInstrument (via Instrument)
                ->leftJoin('inst.typeInstrument', 'typeInst')
                ->addSelect('typeInst')

                // NOUVEAU: Join pour Marque (via Instrument)
                ->leftJoin('inst.marque', 'marq')
                ->addSelect('marq')

                // Join for Professionnel
                ->leftJoin('i.professionnel', 'prof')
                ->addSelect('prof')
                
                ->orderBy('i.id', 'ASC')
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            // Log the error (optional, but good practice)
            // error_log("Doctrine Query Error in InterventionRepository: " . $e->getMessage()); 
            
            // If the query fails (e.g., relation doesn't exist), fall back to a simple findAll() 
            // to avoid stopping the entire application and show at least some data.
            // THIS IS A DEBUG FALLBACK! 
            return $this->findAll();
        }
    }

    // Add other repository methods here
}
