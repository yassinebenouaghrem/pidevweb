<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ResconsRepository;
use http\Client\Curl\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;


/**
 * @Route("/reservation")
 */

class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(Request $request ,PaginatorInterface $paginator): Response
    {
        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findAll();
        $reservations = $paginator->paginate(
            $reservations,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
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
        $this->get('twig')->addGlobal('entity', $att);
        $this->get('twig')->addGlobal('entityconf', $conf);

    }

    /**
     * @Route("/resform2", name="res_show", methods={"GET"})
     */
    public function afficherres(): Response
    {
$this->test();
        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findAll();
        $consultation = $this->getDoctrine()
            ->getRepository(\App\Entity\User::class)
            ->findAll();
        return $this->render('reservation/confirmationreservationtherapeute.html.twig', [
            'reservations' => $reservations,
            'users'=>$consultation,
        ]);
    }

    /**
     * @param ResconsRepository $Repository
     * @return Response
     * @Route("/stat", name="stat_show")
     */
    public function statfn(ResconsRepository $resconsRepository){
$this->test();
        $forum = $resconsRepository->countByDate();
        $dates = [];
        $annoncesCount = [];
        foreach($forum as $foru){

            $dates [] = $foru['date'];
            $annoncesCount[] = $foru['count'];
        }
        $this->get('twig')->addGlobal('dates', $dates);
        $this->get('twig')->addGlobal('annoncesCount', $annoncesCount);

        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $rd=0;
        $qu=0;
        $es=0;


        foreach ($reservations as $reservations)
        {
            if (  $reservations->getType()=="en ligne")  :

                $rd+=1;
            elseif ($reservations->getType()=="a domicile"):

                $qu+=1;

            endif;

        }


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Statistique des réservations en ligne et a domicile', 'nombres'],
                ['en ligne',     $rd],
                ['a domicile',      $qu],
            ]
        );
        $pieChart->getOptions()->setTitle('Statistique des réservations en ligne et a domicile');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('reservation/stat.html.twig', array('piechart' => $pieChart)
    );

    }
    /**
     * @Route("/notif/test", name="notif_show")
     */
    public function notiffn(){
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


        return $this->render('base.html.twig',[
            'nbatt'=>$att,
        'nbconf'=>$conf,
        ]);
    }

    /**
     * @Route("/new/{consultation}", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request, Consultation $consultation): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $reservation->setImage($consultation->getImage());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reservation->setIdconsultation($consultation->getId());
            $reservation->setIdclient(12);

            $reservation->setDate($consultation->getDate());
            $reservation->setCintherapeute($consultation->getIdtherapeute());

            $reservation->setHeure($consultation->getHeuredeb());
            $reservation->setHeurefin($consultation->getHeurefin());

            $consultation->setEtat('Reservé');
            $entityManager->persist($reservation);
            $entityManager->flush();
            $entityManager->persist($consultation);
            $entityManager->flush();


            return $this->redirectToRoute('consultation_afficher');
        }

        return $this->render('reservation/new.html.twig', [

            'reservation' => $reservation,
            'form' => $form->createView(),

        ]);
    }
    /**
     * @Route("/{idreservation}/test", name="reservation_modifier", methods={"POST"})
     */

    public function modifieretat(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('modifier'.$reservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $reservation->setEtat('Confirmé');
            $entityManager->flush();
        }

        return $this->redirectToRoute('res_show');
    }
    /**
     * @Route("/trires", name="trires_affichage")
     */
    public function Tri(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT a FROM App\Entity\Reservation a 
            ORDER BY a.date ASC'
        );

        $reservation = $query->getResult();

        $reservation = $paginator->paginate(
            $reservation,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('reservation/index.html.twig',
            array('reservations' => $reservation));

    }
    /**
     * @Route("/modif/{idreservation}", name="reservation_attente", methods={"POST"})
     */

    public function modifieretatatt(Request $request, Reservation $reservation): Response
    {

        if ($this->isCsrfTokenValid('attente'.$reservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $reservation->setEtat('En attente de confirmation');
            $entityManager->flush();
        }

        return $this->redirectToRoute('res_show');
    }
    /**
     * @Route("/{idreservation}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{idreservation}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reservation->setEtat('En attente de confirmation');

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

   /**
     * @Route("/{idreservation}/delete", name="reservation_delete", methods={"POST"})
     */
   public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($reservation);
            $entityManager->flush();
            $consultation = $this->getDoctrine()
                ->getRepository(Consultation::class)
                ->find($reservation->getIdconsultation());
            $consultation->setEtat('Disponible');
            $entityManager->persist($consultation);
            $entityManager->flush();

        }

        return $this->redirectToRoute('res_show');
    }

    /**
     * @Route("/{idreservation}/delete2", name="reservation_deletefront", methods={"POST"})
     */
    public function deletefront(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdreservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
            $consultation = $this->getDoctrine()
                ->getRepository(Consultation::class)
                ->find($reservation->getIdconsultation());
            $consultation->setEtat('Disponible');
            $entityManager->persist($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
    /**
     * @param ResconsRepository $Repository
     * @return Response
     * @Route ("/reservation/statt2", name="statt2")
     */

    public function statistiques(ResconsRepository $resconsRepository){
        $forum = $resconsRepository->countByDate();
        $dates = [];
        $annoncesCount = [];
        foreach($forum as $foru){

            $dates [] = $foru['date'];
            $annoncesCount[] = $foru['count'];
        }
        return $this->render('reservation/stat2.html.twig', [
            'dates' => $dates,
            'annoncesCount' => $annoncesCount
        ]);
    }
}
