<?php

namespace App\Controller;
use App\Entity\Notifications;
use App\Repository\EvenementRepository;
use App\Entity\Evenement;
use App\Entity\ReservationEvent;
use App\Entity\FitreRecherche;
use App\Form\FitreRechercheType;
use App\Form\EvenementType;
use App\Form\ReservationEventType;
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
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->AfficherEvenementencours();

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        $notification=$this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat','non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();

$nbrNotif=$this->getDoctrine()
    ->getRepository(Evenement::class)
    ->CompterNbNotif();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'notification'=> $notification,
            'nbrNotif'=>$nbrNotif,

        ]);
    }

    /**
     * @Route("/evenementeffectue", name="evenementeffectue", methods={"GET"})
     */
    public function evenementeffectue(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->AfficherEvenementeffectue();

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        $notification=$this->getDoctrine()
            ->getRepository(Notifications::class)
            ->createQueryBuilder('e')
            ->where('e.etat like :etat')
            ->setParameter('etat','non lu')
            ->addOrderBy('e.id', 'desc')
            ->getQuery()
            ->execute();

        $nbrNotif=$this->getDoctrine()
            ->getRepository(Evenement::class)
            ->CompterNbNotif();

        return $this->render('evenement/EvenementEffectueBack.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'notification'=> $notification,
            'nbrNotif'=>$nbrNotif,

        ]);
    }
    /**
     * @Route("/mesreservationseffectue", name="mesreservationsEffectue_index", methods={"GET"})
     */
    public function mesreservationsEffectue(): Response
    {
        $reservation = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindReservationEffectuee();

        $etatReservations = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatReservation();

        return $this->render('evenement/ReservationEffectueClient.html.twig', [
            'reservations' => $reservation,
            'etatReservation'=>$etatReservations,

        ]);
    }

    /**
     * @Route("/mesreservations", name="mesreservations_index", methods={"GET"})
     */
    public function mesreservations(): Response
    {
        $reservation = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindReservationEncours();

        $etatReservations = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatReservation();

        return $this->render('evenement/GestionReservation.html.twig', [
            'reservations' => $reservation,
            'etatReservation'=>$etatReservations,

        ]);
    }

    /**
     * @Route("/evenementfront", name="evenementFront_index", methods={"GET"})
     */
    public function indexFront(Request $request): Response
    {
        $search = new FitreRecherche();
        $form= $this->createForm(FitreRechercheType::class,$search);
        $form -> handleRequest($request);


        $evenement= new Evenement();

        $dateevent=$evenement->getDateEvent();
        $datejour=date("Y-m-d");
        $timestamp1 = strtotime($dateevent);
        $timestamp2 = strtotime($datejour);
        if ($timestamp1 >= $timestamp2)
        {
            $evenement->setEtat("effectue");
        }


        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->FindEventEncours($search);

        $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->changerEtatEvent();

        return $this->render('evenement/EvenenementFront.html.twig', [
            'evenements' => $evenements,
            'event' => $event,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/accueilfront", name="accueilfront_index", methods={"GET"})
     */
    public function accueilfront(Request $request): Response
    {



        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->EventLeplusReserver();

        $dernier=$this->getDoctrine()
            ->getRepository(Evenement::class)
            ->DernierEventAjoute();

        return $this->render('evenement/accueilFront.html.twig', [
            'evenements' => $evenements,
            'dernier'=>$dernier,
        ]);
    }


    /**
     * @Route("/lireplus/{id}", name="lireplusevenement_index", methods={"GET","POST"})
     */
    public function showLirePlusEvent(Request $request,Evenement $evenement): Response
    {

        $notification = new Notifications();
$titre =$evenement->getTitre();


        $ReservationEvent= new ReservationEvent();
        $form = $this->createForm(ReservationEventType::class, $ReservationEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $placeDispo=$evenement->getCapacite()-$evenement->getNbReservation();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager2 = $this->getDoctrine()->getManager();

            if ($ReservationEvent->getNbPlace()>$placeDispo)
            {
                echo "<script type = \"text/javascript\">
                    alert(\"Il ne reste plus que \"+$placeDispo +\" places pour cette événement. Vous ne pouvez pas réserver plus !\");
                    </script>";
            }
            else
            {
                $notification->setEtat("non lu");
                $notification->setMotif("Vous avez une nouvelle réservation pour l'événement $titre"  );
                $dateNotif = new \DateTime();
                $notification->setDate($dateNotif);
                $entityManager2->persist($notification);
                $entityManager2->flush();


                $entityManager->persist($ReservationEvent);

            $ReservationEvent->setIdOrganisateur($evenement->getIdOrganisateur());
            $ReservationEvent->setIdEvent($evenement->getId());
            $ReservationEvent->setEtat("en cours");

                $ReservationEvent->setTitreEvent($evenement->getTitre());
                $ReservationEvent->setImageEvent($evenement->getImage());
                $ReservationEvent->setDateEvent($evenement->getDateEvent());

                $ReservationEvent->setTotal($ReservationEvent->getNbPlace()*$evenement->getTarif());
            $evenement->setNbReservation($evenement->getNbReservation()+$ReservationEvent->getNbPlace());



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

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$evenement->getImage();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('imgEvent'),
                    $filename
                );
            } catch (FileException $e) {

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);


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
            $file=$evenement->getImage();
            $filename= md5(uniqid()).'.'.$file->guessExtension();
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
}
