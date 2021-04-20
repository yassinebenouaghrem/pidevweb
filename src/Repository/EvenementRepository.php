<?php

namespace App\Repository;
use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\FitreRecherche;
use Doctrine\ORM\Query;


class EvenementRepository extends \Doctrine\ORM\EntityRepository
{

public function FindEventEncours(FitreRecherche $search)
            {
                  $entityManager= $this->getEntityManager();

                $query=$entityManager
                    ->createQuery("select e from App\Entity\Evenement e where 
                      e.etat LIKE :etat and ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )>=0)")
                    ->setParameter('etat', 'en cours');
/*
                $query2=$entityManager
                    ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0) 
                    ");
*/
                if ($search->getPrixMax()){
                    $query=$entityManager
                        ->createQuery('select e from App\Entity\Evenement e where 
                      e.tarif <= :PrixMax')
                        ->setParameter('PrixMax',  $search->getPrixMax());

                }
                if ($search->getTypeEvent()){

                    $query=$entityManager
                        ->createQuery('select e from App\Entity\Evenement e where 
                      e.type = :TypeEvent')
                        ->setParameter('TypeEvent', $search->getTypeEvent());
                }



                if ($search->getTypeEvent() && $search->getPrixMax()){

                    $query=$entityManager
                        ->createQuery('select e from App\Entity\Evenement e where 
                      e.type = :TypeEvent and  
                      e.tarif <= :PrixMax ')
                        ->setParameter('TypeEvent', $search->getTypeEvent())
                        ->setParameter('PrixMax', $search->getPrixMax());

                }
                  return $query->getResult() ;

            }


    public function changerEtatEvent()
    {
        $entityManager= $this->getEntityManager();
        $query2=$entityManager
            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0) 
                    ");
        return $query2->getResult();
    }
    public function DecrementerPLace(int $nbPLace,int $idEvent)
    {
        $entityManager= $this->getEntityManager();
        $query2=$entityManager
            ->createQuery("update App\Entity\Evenement e  set e.nbReservation= (e.nbReservation-:nbPlace) where (e.id=:idEvent)")
            ->setParameter('nbPlace', $nbPLace)
           ->setParameter('idEvent', $idEvent);


        return $query2->getResult();
    }


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

    public function FindReservationEffectuee()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select r from App\Entity\ReservationEvent r where 
                      r.etat LIKE :etat and ((DATE_DIFF( r.dateEvent,CURRENT_DATE()) )<=0)")
            ->setParameter('etat', 'effectue');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

    public function changerEtatReservation()
    {
        $entityManager= $this->getEntityManager();
        $query2=$entityManager
            ->createQuery("update App\Entity\ReservationEvent e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0) 
                    ");
        return $query2->getResult();
    }

    public function ModifierReservation(int $idEvent,int $AncienNbPlace,int $nvNbPlace)
    {
        $entityManager= $this->getEntityManager();
        $query2=$entityManager
            ->createQuery("update App\Entity\Evenement e  set e.nbReservation= ((e.nbReservation-:AncienNbPlace)+:nvNbPlace) where (e.id=:idEvent)
                    ")
            ->setParameter('AncienNbPlace', $AncienNbPlace)
            ->setParameter('nvNbPlace', $nvNbPlace)
            ->setParameter('idEvent', $idEvent);

        return $query2->getResult();
    }

    public function AfficherEvenement(int $idEvent)
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select e from App\Entity\Evenement e where 
                     (e.id=:idEvent)")
            ->setParameter('idEvent', $idEvent);
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

    public function CompterNbNotif()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select COUNT(n) from App\Entity\Notifications n ");
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

    public function ModifierEtatNotif(int $id)
    {
        $entityManager= $this->getEntityManager();
        $query2=$entityManager
            ->createQuery("update App\Entity\Notifications e  set e.etat= 'lu' where (e.id=:id)
                    ")
            ->setParameter('id', $id);


        return $query2->getResult();
    }


    public function EventLeplusReserver()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select r   from App\Entity\Evenement r where 
                       r.nbReservation= (SELECT MAX(e.nbReservation)
                              FROM App\Entity\Evenement e
                             WHERE  e.etat LIKE :etat  and ((DATE_DIFF( r.dateEvent,CURRENT_DATE()) )>=0) )")
            ->setParameter('etat', 'en cours');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

    public function DernierEventAjoute()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select r from App\Entity\Evenement r where 
                      r.id= (SELECT MAX(e.id)
                              FROM App\Entity\Evenement e
                             WHERE  e.etat LIKE :etat)")

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
                     e.id = r.idEvent")
            ->setParameter('etat', 'en cours');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }
    public function AfficherEvenementencours()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select e from App\Entity\Evenement e where 
                     (e.etat=:etat)")
            ->setParameter('etat', 'en cours');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }

    public function AfficherEvenementeffectue()
    {
        $entityManager= $this->getEntityManager();

        $query=$entityManager
            ->createQuery("select e from App\Entity\Evenement e where 
                     (e.etat=:etat)")
            ->setParameter('etat', 'effectue');
        /*
                        $query2=$entityManager
                            ->createQuery("update App\Entity\Evenement e  set e.etat= 'effectue' where ((DATE_DIFF( e.dateEvent,CURRENT_DATE()) )<=0)
                            ");
        */


        return $query->getResult() ;

    }
}


