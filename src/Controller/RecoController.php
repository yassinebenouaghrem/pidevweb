<?php

namespace App\Controller;

use App\Entity\Reco;
use App\Entity\Rating;
use App\Entity\User;
use App\Entity\Comment;

use App\Form\CommentType;
use App\Form\RecoType;
use App\Repository\CommentRepository;
use App\Repository\RatingRepository;
use App\Repository\RecoRepository;
use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use FontLib\EOT\File;
use Knp\Component\Pager\PaginatorInterface;
use MongoDB\Driver\Session;
use Svg\Tag\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reco")
 */
class RecoController extends AbstractController
{
    /**
     * @Route("/", name="reco_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator): Response
    {
        $recos = $this->getDoctrine()
            ->getRepository(Reco::class)
            ->findAll();

        return $this->render('reco/index.html.twig', [
            'recos' => $recos,
        ]);
    }

    /**
     * @Route("/new", name="reco_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reco = new Reco();
        $form = $this->createForm(RecoType::class, $reco);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $file =$reco->getImage();


            $filename= $file->getClientOriginalName();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $reco->setImage($filename);

            $entityManager->persist($reco);
            $entityManager->flush();

            return $this->redirectToRoute('reco_index');
        }

        return $this->render('reco/new.html.twig', [
            'reco' => $reco,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reco_show", methods={"GET"})
     */
    public function show(Reco $reco): Response
    {
        return $this->render('reco/show.html.twig', [
            'reco' => $reco,
        ]);
    }

    /**
     * @Route("recofront/{id}", name="reco_single", methods={"GET"})
     */
    public function showreco(Reco $reco): Response
    {
        return $this->render('reco/recosingle.html.twig', [
            'reco' => $reco,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="reco_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reco $reco): Response
    {
        $form = $this->createForm(RecoType::class, $reco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file =$reco->getImage();


            $filename= $file->getClientOriginalName();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $reco->setImage($filename);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reco_index');
        }

        return $this->render('reco/edit.html.twig', [
            'reco' => $reco,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reco_delete", methods={"POST"})
     */
    public function delete(Request $request, Reco $reco): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reco->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reco);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reco_index');
    }

    /**
     *      * @Route("/front/front", name="front")

     */

    public function front(PaginatorInterface $paginator,Request $request):Response
    {



        $recos = $this->getDoctrine()
            ->getRepository(Reco::class)
            ->findAll();
        $recos = $paginator->paginate(
            $recos,
            $request->query->getInt('page',1),
            3);

        return $this->render('reco/recofront.html.twig', [
            'recos' => $recos,
        ]);
    }
    /**
    * @Route("/front/{ratingIndex}", name="rating", methods={"PUT","Get"})

     */

    public function rating (Request $request,$ratingIndex):Response
    {        $session = $request->getSession();
        $exist=$this->getDoctrine()->getRepository(Rating::class)->findBy(array('email'=>$session->get("email")));

        $recos = $this->getDoctrine()
            ->getRepository(Reco::class)
            ->findAll();
        $rating= new Rating();




        $entityManager = $this->getDoctrine()->getManager();
        if($exist ==null){
            $b=$ratingIndex+1;
            $rating->setRating($b);
            $rating->setEmail($session->get("email"));
        $entityManager->persist($rating);
        $entityManager->flush();
        }
        else{
            $rating1=$this->getDoctrine()->getRepository(Rating::class)->findOneBy(array('email'=>$session->get("email")));
            $rating1->setEmail($session->get("email"));
            $rating1->setRating($ratingIndex+1);
            $entityManager->flush();
        }









        return $this->render('reco/recofront.html.twig', [
            'recos' => $recos,
        ]);
    }
    /**
     * @Route("reco/{id}", name="reco_single", methods={"GET","POST"})
     */
    public function reco_single(RecoRepository $recoRepository,$id,Request $request,UserRepository $clientRepository,CommentRepository $commentRepository): Response
    {         $session = $request->getSession();
        $a=$session->get("email");

        $Recotype = $recoRepository->findBy(['id' => $id]);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {$myOptions = array('strictness' => 'permissive', 'also_check' => array('foobar'));
            $filter = new \JCrowe\BadWordFilter\BadWordFilter($myOptions);

            $cleanString = $filter->clean($comment->getContent());


            $entityManager = $this->getDoctrine()->getManager();
            $val = $entityManager->getRepository(Reco::class)->find($id);
            $user2=$this->getDoctrine()->getRepository(User::class)->findOneBy(
                ['email' => $session->get("email")],
            );
            $value=$user2->getId();
            $comment->setCreatedAt(new \DateTime())
                ->setIdreco($val)
                ->setIduser($user2)
                 ->setContent($cleanString);

            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('reco_single',['id'=>$id]);
        }
        $recocomment = $commentRepository->findBy(['idreco'=>$id]);
        return $this->render('reco/recosingle.html.twig', [
            'recos' => $Recotype,
            'comments'=>$recocomment,
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route("/deletecom/{id}",name="deletecom",methods={"DELETE"})
     */
    public function deletecom(Request $request,Comment $comment)
    {
        if($this->isCsrfTokenValid('delete'.$comment->getId(),$request->request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front');
    }
    /**
     * @Route("/reco/pdf", name="pdf1")
     */
    public function Liste(){
        $repository=$this->getDoctrine()->getRepository(Reco::class);
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $recommandation=$repository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reco/recopdf.html.twig',
            ['recommandations'=>$recommandation])

        ;

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Liste_recommandations.pdf", [
            'isRemoteEnabled' => true,
            "Attachment" => true
        ]);


    }

}
