<?php

namespace App\Repository;
use App\Entity\Evenement;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

class ReservationRepository extends \Doctrine\ORM\EntityRepository
{
/*
    public function changerEtatEvent()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery('select r from App\Entity\ReservationEvent r where 
                      join r.')
            ->setParameter('TitreEvenement', $Reservation);
        return $query->getResult();
    }
*/
    public function FindReservationEncours()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select r from App\Entity\ReservationEvent r where 
                      r.etat LIKE :etat and ((DATE_DIFF( r.dateEvent,CURRENT_DATE()) )>=0)")
            ->setParameter('etat', 'en cours');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

    public function FindReservation()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select r,e from App\Entity\ReservationEvent r,App\Entity\Evenement e where 
                     e.id = r.id_event")
            ->setParameter('etat', 'en cours');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

}
