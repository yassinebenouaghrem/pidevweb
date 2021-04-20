<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
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

    public function finduser($username,$mdp,$etat){
        return $this->createQueryBuilder('u')
            ->where('u.email=:email')
            ->andWhere('u.password =:mdp')
            ->andWhere('u.etat=:etat')
            ->setParameter('email',$username)
            ->setParameter('mdp',$mdp)
            ->setParameter('etat',$etat)
            ->getQuery()->getResult();
}
    public function findadmin($username,$mdp,$etat){
        return $this->createQueryBuilder('u')
            ->where('u.email=:email')
            ->andWhere('u.password =:mdp')
            ->andWhere('u.type=:etat')

            ->setParameter('email',$username)
            ->setParameter('mdp',$mdp)
            ->setParameter('etat',$etat)
            ->getQuery()->getResult();
    }
    public function moyenne()
    { $query = $this->getEntityManager()
        ->createQuery("SELECT r from App\Entity\Rating r");



        // returns an array of Product objects
        return $query->getResult();
    }
    public function finduseremail($username){
        return $this->createQueryBuilder('u')
            ->where('u.email=:email')

            ->setParameter('email',$username)

            ->getQuery()->getFirstResult();
    }
}
