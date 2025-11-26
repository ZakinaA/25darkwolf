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
     * Cette méthode est nécessaire car Doctrine ne peut pas trier facilement sur une colonne liée (Jour) sans index spécifique.
     * @return Cours[] Returns an array of Cours objects
     */
    public function findAllSortedByDayAndTime(): array
    {
        // Ordre des jours pour le tri manuel (il faut adapter cet ordre si votre entité Jour a un champ 'ordre' numérique)
        // Les clés doivent correspondre aux libellés de vos entités Jour.
        $dayOrder = [
            'Lundi' => 1, 
            'Mardi' => 2, 
            'Mercredi' => 3, 
            'Jeudi' => 4, 
            'Vendredi' => 5, 
            'Samedi' => 6, 
            'Dimanche' => 7
        ];

        // 1. Récupérer tous les cours avec les relations Jour, TypeInstrument et Professeur chargées (JOIN)
        $cours = $this->createQueryBuilder('c')
            ->leftJoin('c.jour', 'j')->addSelect('j')
            ->leftJoin('c.typeInstrument', 'ti')->addSelect('ti')
            ->leftJoin('c.professeur', 'p')->addSelect('p')
            ->orderBy('c.heureDebut', 'ASC') // Tri initial par heure de début
            ->getQuery()
            ->getResult();

        // 2. Tri manuel en PHP pour garantir l'ordre Lundi, Mardi, Mercredi...
        usort($cours, function (Cours $a, Cours $b) use ($dayOrder) {
            
            // Récupère le libellé du jour (assurez-vous que l'entité Jour a bien une méthode getLibelle())
            $jourA = $a->getJour() ? $a->getJour()->getLibelle() : 'Inconnu';
            $jourB = $b->getJour() ? $b->getJour()->getLibelle() : 'Inconnu';
            
            // Détermine le rang du jour
            $dayRankA = $dayOrder[$jourA] ?? 99; // 99 pour les jours non reconnus
            $dayRankB = $dayOrder[$jourB] ?? 99;

            // Comparaison principale : par jour
            if ($dayRankA !== $dayRankB) {
                return $dayRankA <=> $dayRankB;
            }

            // Comparaison secondaire (si les jours sont les mêmes) : par heure de début
            // Note : Cette comparaison fonctionne car les heures sont des objets DateTime
            return $a->getHeureDebut() <=> $b->getHeureDebut();
        });

        return $cours;
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
            
            // Tri : D'abord par jour (via la relation Jour), puis par heure de cours
            // ATTENTION : Le tri Doctrine 'c.jour' pourrait ne pas respecter l'ordre Lundi, Mardi, ... 
            // Si c'est le cas, il faudrait appliquer un tri manuel comme dans findAllSortedByDayAndTime().
            ->orderBy('c.jour', 'ASC')
            ->addOrderBy('c.heureDebut', 'ASC')
            
            ->getQuery()
            ->getResult();
    }
}