<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Notifications;
use App\Entity\ReservationEvent;
use App\Form\ReservationEventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation/event")
 */
class ReservationEventController extends AbstractController
{
    /**
     * @Route("/", name="reservation_event_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reservationEvents = $this->getDoctrine()
            ->getRepository(ReservationEvent::class)
            ->findAll();

        return $this->render('reservation_event/index.html.twig', [
            'reservation_events' => $reservationEvents,
        ]);
    }

    /**
     * @Route("/gererreservation", name="GererReservation_event_index", methods={"GET"})
     */
    public function GererReservationBack(): Response
    {

        $reservationEvents = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindReservationEncours();

        $notification=$this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat','non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();



        return $this->render('reservation_event/reservationBack.html.twig', [
            'reservation_events' => $reservationEvents,
            'notification'=> $notification,

        ]);
    }

    /**
     * @Route("/gererreservationeffectue", name="gererreservationeffectue", methods={"GET"})
     */
    public function gererreservationeffectue(): Response
    {

        $reservationEvents = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindReservationEffectuee();

        $notification=$this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat','non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();



        return $this->render('reservation_event/ResevationEffectueBack.html.twig', [
            'reservation_events' => $reservationEvents,
            'notification'=> $notification,

        ]);
    }

    /**
     * @Route("/new", name="reservation_event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservationEvent = new ReservationEvent();
        $form = $this->createForm(ReservationEventType::class, $reservationEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationEvent);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_event_index');
        }

        return $this->render('reservation_event/new.html.twig', [
            'reservation_event' => $reservationEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_event_show", methods={"GET"})
     */
    public function show(ReservationEvent $reservationEvent): Response
    {
        return $this->render('reservation_event/show.html.twig', [
            'reservation_event' => $reservationEvent,
        ]);
    }

    /**
     * @Route("/{id}/{idEvent}/{nbPlace}/{titreEvent/edit", name="reservation_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReservationEvent $reservationEvent): Response
    {

        $titreEvent = $request->get("titreEvent");

        $notification = new Notifications();


        $evenement = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->find($reservationEvent->getIdEvent());

        $id_event=$request->get("idEvent");
        $nbplace=$request->get("nbPlace");

        $form = $this->createForm(ReservationEventType::class, $reservationEvent);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager2 = $this->getDoctrine()->getManager();

            $notification->setEtat("non lu");
            $notification->setMotif("Un client a modifié sa réservation pour l'événement $titreEvent"  );
            $dateNotif = new \DateTime();
            $notification->setDate($dateNotif);
            $entityManager2->persist($notification);
            $entityManager2->flush();
            
           $nvNbPlace= $reservationEvent->getNbPlace();

            $em1 = $this->getDoctrine()->getManager();
            $em1->getRepository(Evenement::class)->ModifierReservation($id_event,$nbplace,$nvNbPlace);
            $em1->flush();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mesreservations_index');
        }

        return $this->render('reservation_event/edit.html.twig', [
            'reservation_event' => $reservationEvent,
            'form' => $form->createView(),
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_event_delete", methods={"POST"})
     */
    public function delete(Request $request, ReservationEvent $reservationEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_event_index');
    }

    /**
     * @Route("/{id}/{idEvent}/{nbPlace}/{titreEvent}/delete", name="reservation_delete", methods={"GET","POST"})
     */
    public function deleteReservation(Request $request): Response
    {

        $titreEvent = $request->get("titreEvent");

        $notification = new Notifications();
        $entityManager2 = $this->getDoctrine()->getManager();

        $notification->setEtat("non lu");
        $notification->setMotif("Un client a annulé sa réservation pour l'événement $titreEvent"  );
        $dateNotif = new \DateTime();
        $notification->setDate($dateNotif);
        $entityManager2->persist($notification);
        $entityManager2->flush();


        $id = $request->get("id");
    $id_event=$request->get("idEvent");
        $nbplace=$request->get("nbPlace");

            $reservation = $this->getDoctrine()->getRepository(ReservationEvent::class)->find($id);
            $em = $this->getDoctrine()->getManager();

            $em->remove($reservation);
            $em->flush();



        $em1 = $this->getDoctrine()->getManager();

        $em1->getRepository(Evenement::class)->DecrementerPLace($nbplace,$id_event);
$em1->flush();


        return $this->redirectToRoute('mesreservations_index');
    }


    /**
     * @Route("/{id}/Notif", name="notification", methods={"GET","POST"})
     */
    public function ResultatNotif(Request $request): Response
    {



        $id = $request->get("id");


        $etatNotif = $this->getDoctrine()->getRepository(Evenement::class)->ModifierEtatNotif($id);
        $em = $this->getDoctrine()->getManager();

        $em->flush();



        return $this->redirectToRoute('GererReservation_event_index');
    }

}
