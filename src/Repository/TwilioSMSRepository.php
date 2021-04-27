<?php

namespace App\Repository;

use App\Entity\TwilioSMS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TwilioSMS|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwilioSMS|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwilioSMS[]    findAll()
 * @method TwilioSMS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwilioSMSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwilioSMS::class);
    }

    // /**
    //  * @return TwilioSMS[] Returns an array of TwilioSMS objects
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
    public function findOneBySomeField($value): ?TwilioSMS
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
