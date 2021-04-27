<?php

namespace App\Controller;
use App\Entity\Notifications;
use App\Entity\User;
use App\Form\SearchType;
use App\Repository\EvenementRepository;
use App\Entity\Evenement;
use App\Entity\ReservationEvent;
use App\Entity\FitreRecherche;
use App\Form\FitreRechercheType;
use App\Form\EvenementType;
use App\Form\ReservationEventType;
use App\Services\QrcodeService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{

    /**
     * @Route("/statistique", name="statistique", methods={"GET"})
     */
    public function stat(Request $request): Response
    {
        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\Therapeute::class)->findOneBy(
            ['email' => $a],
        );

        $statplusreserver = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->StatTypeEventleplusreserver();

        $NomType = [];
        $countType = [];

        $evenementstat = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->StatTypeEventleplusreserver();
        foreach ($evenementstat as $evenementstat) {
            $countType[] = $evenementstat['reserv'];
            $NomType[] = $evenementstat['type'];


        }

        $NomModeP= [];
        $countModeP = [];

        $modeP= $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->modePaiementleplusUtiliser();
        foreach ($modeP as $modeP) {
            $countModeP[] = $modeP['countM'];
            $NomModeP[] = $modeP['modePaiement'];


        }

        $TitreEvent= [];
        $nbREvent = [];

        $EvolutionR= $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->StatEvolutionReservation($user2->getId());
        foreach ($EvolutionR as $EvolutionR) {
            $TitreEvent[] = $EvolutionR['titre'];
            $nbREvent[] = $EvolutionR['reserve'];
        }

        $typeEtat= [];
        $countEtat = [];

        $StatEtat= $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->statEtatEvenement($user2->getId());
        foreach ($StatEtat as $StatEtat) {
            $typeEtat[] = $StatEtat['etat'];
            $countEtat[] = $StatEtat['countEtat'];
        }



        $notification = $this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat', 'non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();

        $totalReser=0 ;
        $nbReservationTotal = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->nbReservationTotal($user2->getId());
        foreach ($nbReservationTotal as $nbReservationTotal) {
            $totalReser = $nbReservationTotal['total'];
        }

        $revenueTotalEenligne= 0 ;
        $RevenueEnligne = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->RevenueEnligne($user2->getId());
        foreach ($RevenueEnligne as $RevenueEnligne) {
            $revenueTotalEenligne = $RevenueEnligne['total'];
        }

        $revenueencaissesurplace= 0 ;
        $RevenuesurplaceEffectue = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->RevenuesurplaceEffectue($user2->getId());
        foreach ($RevenuesurplaceEffectue as $RevenuesurplaceEffectue) {
            $revenueencaissesurplace = $RevenuesurplaceEffectue['total'];
        }

        $revenueAAAencaissesurplace= 0 ;
        $RevenuesurplaceAvenir = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->RevenuesurplaceAvenir($user2->getId());
        foreach ($RevenuesurplaceAvenir as $RevenuesurplaceAvenir) {
            $revenueAAAencaissesurplace = $RevenuesurplaceAvenir['total'];
        }

        $nbrNotif = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->CompterNbNotif();

        $ProgressionEventEncours = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->statProgressionEvenement($user2->getId());

        $RappelEvent = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->RappelEvent($user2->getId());

        return $this->render('evenement/stats.html.twig', [
            'NomType' => json_encode($NomType),
            'countType' => json_encode($countType),
            'evenementstat' => $evenementstat,
            'notification' => $notification,
            'nbrNotif' => $nbrNotif,
            'NomModeP' => json_encode($NomModeP),
            'countModeP' => json_encode($countModeP),
            'modeP' => $modeP,
            'TitreEvent'=>  json_encode($TitreEvent),
            'nbREvent'=> json_encode($nbREvent),
            'typeEtat'=>  json_encode($typeEtat),
            'countEtat'=> json_encode($countEtat),
            'ProgressionEventEncours' => $ProgressionEventEncours,
            'RappelEvent'=>$RappelEvent,
            'nbReservationTotal'=>$nbReservationTotal,
            'totalReser'=> json_encode($totalReser),
            'revenueTotalEenligne'=> json_encode($revenueTotalEenligne),
            'revenueencaissesurplace'=> json_encode($revenueencaissesurplace),
            'revenueAAAencaissesurplace'=> json_encode($revenueAAAencaissesurplace),


        ]);
    }

    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new FitreRecherche();

        $form = $this->createForm(FitreRechercheType::class, $search);
        $form->handleRequest($request);


        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\Therapeute::class)->findOneBy(
            ['email' => $a],
        );

        $pagination = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->AfficherEvenementencours($search,$user2->getId());

        $evenements = $paginator->paginate(
            $pagination,
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );




        $NomModeP= [];
        $countModeP = [];

        $modeP= $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->modePaiementleplusUtiliser();
        foreach ($modeP as $modeP) {
            $countModeP[] = $modeP['countM'];
            $NomModeP[] = $modeP['modePaiement'];


        }

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        $notification = $this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat', 'non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();

        $nbrNotif = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->CompterNbNotif();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'notification' => $notification,
            'nbrNotif' => $nbrNotif,
            'form' => $form->createView(),
            'NomModeP' => json_encode($NomModeP),
            'countModeP' => json_encode($countModeP),
            'modeP' => $modeP,


        ]);
    }


    /**
     * @Route("/evenementeffectue", name="evenementeffectue", methods={"GET"})
     */
    public function evenementeffectue(Request $request): Response
    {

        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\Therapeute::class)->findOneBy(
            ['email' => $a],
        );

        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->AfficherEvenementeffectue($user2->getId());

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        $notification = $this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat', 'non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();

        $nbrNotif = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->CompterNbNotif();

        return $this->render('evenement/EvenementEffectueBack.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'notification' => $notification,
            'nbrNotif' => $nbrNotif,

        ]);
    }

    /**
     * @Route("/mesreservationseffectue", name="mesreservationsEffectue_index", methods={"GET"})
     */
    public function mesreservationsEffectue(Request $request): Response
    {
        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['email' => $a],
        );

        $reservation = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindReservationEffectuee($user2->getId());

        $etatReservations = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatReservation();

        return $this->render('evenement/ReservationEffectueClient.html.twig', [
            'reservations' => $reservation,
            'etatReservation' => $etatReservations,

        ]);
    }

    /**
     * @Route("/mesreservations", name="mesreservations_index", methods={"GET"})
     */
    public function mesreservations(Request $request, PaginatorInterface $paginator): Response
    {
        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['email' => $a],
        );

        $pagination = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindReservationEncours($user2->getId());

        $reservation = $paginator->paginate(
            $pagination,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        $etatReservations = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatReservation();

        return $this->render('evenement/GestionReservation.html.twig', [
            'reservations' => $reservation,
            'etatReservation' => $etatReservations,

        ]);
    }

    /**
     * @Route("/evenementfront", name="evenementFront_index", methods={"GET"})
     */
    public function indexFront(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new FitreRecherche();
        $form = $this->createForm(FitreRechercheType::class, $search);
        $form->handleRequest($request);


        $evenement = new Evenement();

        $dateevent = $evenement->getDateEvent();
        $datejour = date("Y-m-d");
        $timestamp1 = strtotime($dateevent);
        $timestamp2 = strtotime($datejour);
        if ($timestamp1 >= $timestamp2) {
            $evenement->setEtat("effectue");
        }


        $pagination = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindEventEncours($search);

        $evenements = $paginator->paginate(
            $pagination,
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        return $this->render('evenement/EvenenementFront.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/accueilfront", name="accueilfront_index", methods={"GET"})
     */
    public function accueilfront(Request $request): Response
    {


        /*
                $evenements = $this->getDoctrine()
                    ->getRepository(Evenement::class)
                    ->EventLeplusReserver();*/

        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat', 'en cours')
            ->addOrderBy('e.nbReservation', 'desc')
            ->setMaxResults(3)
            ->getQuery()
            ->execute();


        $dernier = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->createQueryBuilder('e')
            ->addOrderBy('e.id', 'desc')
            ->setMaxResults(3)
            ->getQuery()
            ->execute();

        return $this->render('evenement/accueilFront.html.twig', [
            'evenements' => $evenements,
            'dernier' => $dernier,
        ]);
    }


    /**
     * @Route("/lireplus/{id}", name="lireplusevenement_index", methods={"GET","POST"})
     */
    public function showLirePlusEvent(Request $request, Evenement $evenement, QrcodeService $qrcodeService,\Swift_Mailer $mailer): Response
    {
        $qrCode = null;

        $notification = new Notifications();
        $titre = $evenement->getTitre();

        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
            ['email' => $a],
        );
        $ReservationEvent = new ReservationEvent();
        $form = $this->createForm(ReservationEventType::class, $ReservationEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $placeDispo = $evenement->getCapacite() - $evenement->getNbReservation();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager2 = $this->getDoctrine()->getManager();

            if ($ReservationEvent->getNbPlace() > $placeDispo) {
                echo "<script type = \"text/javascript\">
                    alert(\"Il ne reste plus que \"+$placeDispo +\" places pour cette événement. Vous ne pouvez pas réserver plus !\");
                    </script>";
            } else {
                $notification->setEtat("non lu");
                $notification->setMotif("Vous avez une nouvelle réservation pour l'événement $titre");
                $dateNotif = new \DateTime();
                $notification->setDate($dateNotif);
                $entityManager2->persist($notification);
                $entityManager2->flush();


                $entityManager->persist($ReservationEvent);

                $ReservationEvent->setIdClient($user2->getId());
                $ReservationEvent->setIdOrganisateur($evenement->getIdOrganisateur());
                $ReservationEvent->setIdEvent($evenement->getId());
                $ReservationEvent->setEtat("en cours");

                $ReservationEvent->setTitreEvent($evenement->getTitre());
                $ReservationEvent->setImageEvent($evenement->getImage());
                $ReservationEvent->setDateEvent($evenement->getDateEvent());

                $ReservationEvent->setTotal($ReservationEvent->getNbPlace() * $evenement->getTarif());
                $evenement->setNbReservation($evenement->getNbReservation() + $ReservationEvent->getNbPlace());
                $nomMail=$user2->getNom();
                $PrenomMail=$user2->getPrenom();
                $nbPLacesmail= $ReservationEvent->getNbPlace();
                $titreMail=$evenement->getTitre();
$contenu="Bonjour $nomMail $PrenomMail.

Vous avez réservez  $nbPLacesmail place(s) pour l'événement $titreMail.
Soyez au rendez vous.

L'équipe de ZenLife vous remercie pour votre confiance" ;


                $message = (new \Swift_Message('Réservation événement ZenLife'))
                    ->setFrom('zenlifezenlife02@gmail.com')
                    ->setTo($user2->getEmail())
                    ->setSubject('Réservation événement ZenLife')
                    ->setBody($contenu);

                $mailer->send($message);
                $data = $ReservationEvent->__toString();
                $namePng = uniqid('', '') . '.png';

                $qrCode = $qrcodeService->qrcode($data, $namePng);

                $ReservationEvent->setQrcode($namePng);
                $entityManager->flush();
                return $this->redirectToRoute('evenementFront_index');
            }
        }


        return $this->render('evenement/lireplusevenement.html.twig', [
            'evenement' => $evenement,
            'formReservation' => $form->createView(),
            'notification' => $notification,
        ]);


    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\Therapeute::class)->findOneBy(
            ['email' => $a],
        );
        $idorga=$user2->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $evenement->getImage();
            $filename= $file->getClientOriginalName();
            try {
                $file->move(
                    $this->getParameter('imgEvent'),
                    $filename
                );
            } catch (FileException $e) {

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);




            $evenement->setIdOrganisateur($idorga);

            $evenement->setEtat("en cours");
            $evenement->setNbReservation(0);
            $evenement->setImage($filename);

            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }


        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $evenement->getImage();
            $filename= $file->getClientOriginalName();
            try {
                $file->move(
                    $this->getParameter('imgEvent'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $evenement->setImage($filename);

            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }


        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="evenement_delete", methods={"GET","POST"})
     */
    public function delete(Request $request): Response
    {

        $id = $request->get("id");
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();


        return $this->redirectToRoute('evenement_index');
    }


    /**
     * @Route("/{id}/detailReservationEvent", name="detailReservationEvent", methods={"GET"})
     */
    public function detailReservationEvent(Request $request): Response
    {
        $id = $request->get("id");

        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->detailReservationEvent($id);

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        $notification = $this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat', 'non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();

        $nbrNotif = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->CompterNbNotif();

        return $this->render('evenement/detailReservationEvenement.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'notification' => $notification,
            'nbrNotif' => $nbrNotif,

        ]);
    }





}
