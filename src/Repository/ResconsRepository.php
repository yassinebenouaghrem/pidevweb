<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResconsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }
    public function countByDate($cinther){
        $query = $this->createQueryBuilder('a')
            ->select('SUBSTRING(a.date, 1, 10) as date, COUNT(a) as count')
            ->where( 'a.cintherapeute = :cinther')->setParameter('cinther',$cinther)
            ->groupBy('date');

        return $query->getQuery()->getResult();

    }

    public function test()
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $att=0;
        $conf=0;


        foreach ($reservations as $reservations)
        {
            if (  $reservations->getEtat()=="En attente de confirmation")  :

                $att+=1;
            else:

                $conf+=1;

            endif;

        }
        return $att;

    }

}
