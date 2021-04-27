<?php

namespace App\Repository;

use App\Entity\Reco;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reco|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reco|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reco[]    findAll()
 * @method Reco[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reco::class);
    }

    // /**
    //  * @return Therapeute[] Returns an array of Therapeute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Therapeute
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


}
