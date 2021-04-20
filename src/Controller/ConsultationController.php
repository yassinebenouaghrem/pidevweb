<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\Reservation;
use App\Form\ConsultationType;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\File;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\ConsultationRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/consultation")
 */

class ConsultationController extends AbstractController
{

    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('handle_search'))
            ->add("query", TextType::class, [
                'attr' => [
                    'placeholder'   => 'Où ?'
                ]
            ])
            ->add("submit", SubmitType::class)
            ->getForm()
        ;

        return $this->render('Consultation/search.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch/{_query?}", name="handle_search", methods={"POST", "GET"})
     */

    public function handleSearchRequest(Request $request, $_query)
    {
        $em = $this->getDoctrine()->getManager();

        if ($_query)
        {
            $data = $em->getRepository(Consultation::class)->findByEmplacement($_query);
        } else {
            $data = $em->getRepository(Consultation::class)->findAll();

        }

        // iterate over all the resuls and 'inject' the image inside
        for ($index = 0; $index < count($data); $index++)
        {
            $object = $data[$index];
            // http://via.placeholder.com/35/0000FF/ffffff

        }

        // setting up the serializer
        $normalizers = [
            new ObjectNormalizer()
        ];

        $encoders =  [
            new JsonEncoder()
        ];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($data, 'json');

        return new JsonResponse($data, 200, [], true);
    }


    /**
     * @Route("/city/{id?}", name="city_page", methods={"GET"})
     */
    public function citySingle(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $city = null;

        if ($id) {
            $city = $em->getRepository(Consultation::class)->findOneBy(['id' => $id]);
        }

        return $this->render('Consultation/cit.html.twig', [
            'consultation'  =>      $city
        ]);
    }
    public function test()
    {
        $repository = $this->getDoctrine()->getRepository(Reservation::class);
        $reservations = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $att=0;
        $conf=0;
        $nb=0;
        $nbconfauj=0;
        $nbattauj=0;
        foreach ($reservations as $reservations)
        {
            if (  $reservations->getEtat()=="En attente de confirmation")  :

                $att+=1;
            else:

                $conf+=1;

            endif;
            if (( $reservations->getDate() )->format('y-m-d')==( new \DateTime() )->format('y-m-d')) :
                $nb++;
            if ($reservations->getEtat() =='Confirmé'):
                $nbconfauj++;
                else:
                    $nbattauj++;

                 endif;
             endif;

        }
        if ($nb>0) :
        $pourcentage=($nbconfauj/$nb)*100;
else :
    $pourcentage=0;
endif;
        $this->get('twig')->addGlobal('nbact', $nb);

        $this->get('twig')->addGlobal('entity', $att);
        $this->get('twig')->addGlobal('conf', $conf);
        $this->get('twig')->addGlobal('confauj', $nbconfauj);
        $this->get('twig')->addGlobal('attauj', $nbattauj);
        $this->get('twig')->addGlobal('pourcauj', $pourcentage);


    }
    public function test2()
    {
        $repository = $this->getDoctrine()->getRepository(Consultation::class);
        $consultation = $repository->findAll();
        $em = $this->getDoctrine()->getManager();
        $disp=0;
        $res=0;
        $nb=0;

        foreach ($consultation as $consultation)
        {

            if (  $consultation->getEtat()=="Disponible")  :

                $disp+=1;
            else:

                $res+=1;

            endif;

        }
        $total=$disp+$res;
        $pourcentage=($res/$total)*100;

        $this->get('twig')->addGlobal('disp', $disp);
        $this->get('twig')->addGlobal('res', $res);
        $this->get('twig')->addGlobal('pourc', $pourcentage);

    }

    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $this->test();
        $consultations = $this->getDoctrine()
            ->getRepository(Consultation::class)
            ->findAll();

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations,
        ]);

    }
    /**
     * @Route("/accueilfou", name="accueil_show", methods={"GET"})
     */
    public function accueil(): Response
    {
        $this->test();
        $this->test2();
        return $this->render('accueil.html.twig', [
        ]);

    }
    /**
     * @Route("/new", name="consultation_new", methods={"GET","POST"})
     */

    public function new(Request $request): Response
    {

        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $consultation->setImage($fileName);
            $consultation->setEtat("Disponible");

            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/affichagefront", name="consultation_afficher", methods={"GET"})
     */
    public function afficherconsultation(Request $request ,PaginatorInterface $paginator,FlashyNotifier $flashy)
    {
        $this->test();
        $flashy->primaryDark('notif!', 'http://your-awesome-link.com');

        $consultations = $this->getDoctrine()
            ->getRepository(Consultation::class)
            ->findAll();
        $consultations = $paginator->paginate(
            $consultations,
            $request->query->getInt('page',1),
            4

        );

        return $this->render('consultation/affichagefront.html.twig', [
            'consultations' => $consultations,
        ]);
    }
    /**
     * @Route("/tri", name="tri_affichage")
     */
    public function Tri(Request $request,PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
            'SELECT a FROM App\Entity\Consultation a 
            ORDER BY a.prix DESC'
        );

        $consultations = $query->getResult();

        $consultations = $paginator->paginate(
            $consultations,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('consultation/affichagefront.html.twig',
            array('consultations' => $consultations));

    }
    /**
     * @Route("/affichagerech", name="consultation_rechtest", methods={"GET"})
     */
    public function recherchettest(Request $request ,PaginatorInterface $paginator)
    {

        $consultations = $this->getDoctrine()
            ->getRepository(Consultation::class)
            ->findAll();
        $consultations = $paginator->paginate(
            $consultations,
            $request->query->getInt('page',1),
            4

        );

        return $this->render('consultation/fronttest.html.twig', [
            'consultations' => $consultations,
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }
    /**
     * @Route("/resform/{id}", name="res_show", methods={"GET"})
     */
    public function afficherres(Request $request,Consultation $consultation): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        return $this->render('consultation/resform.html.twig', [
            'consultation' => $consultation,
            'formreservation' => $form->CreateView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultation $consultation): Response
    {
        $consultation->setImage(
            new File($this->getParameter('images_directory').'/'.$consultation->getImage())
        );
        $form = $this->createForm(ConsultationType::class, $consultation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $consultation->setImage($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consultation_index');

        }

        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/delete/", name="consultation_delete", methods={"GET","POST"})
     */
    public function delete(Request $request): Response
    {
        $id = $request->get("id");
        $consultation = $this->getDoctrine()->getRepository(Consultation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($consultation);
        $em->flush();

        return $this->redirectToRoute('consultation_index');
    }
}
