<?php

namespace App\Controller;

use App\Entity\Therapeute;
use App\Form\TherapeuteType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




/**
 * @Route("/therapeute")
 */
class TherapeuteController extends AbstractController
{

/**
* @Route("/mapF/{id}", name="mapF"))
*/
    public function map($id,\Swift_Mailer $mailer){
        $em=$this->getDoctrine()->getRepository(Therapeute::class);
        $th=$em->find($id);

       return $this->render('user/MAP.html.twig', [
           'f'=>$th

        ]);

    }

    /**
     * @Route("/", name="therapeute_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator): Response
    {
        $therapeutes = $this->getDoctrine()
            ->getRepository(Therapeute::class)
            ->findAll();


        return $this->render('therapeute/index.html.twig', [
            'therapeutes' => $therapeutes,
        ]);
    }

    /**
     * @Route("/new", name="therapeute_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $therapeute = new Therapeute();
        $form = $this->createForm(TherapeuteType::class, $therapeute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $therapeute->setType("therapeute");
               $file =$therapeute->getImage();


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
            $therapeute->setPassword(md5($therapeute->getPassword()));
            $therapeute->setImage($filename);
            $entityManager->persist($therapeute);
            $entityManager->flush();

            return $this->redirectToRoute('therapeute_index');
        }

        return $this->render('therapeute/new.html.twig', [
            'therapeute' => $therapeute,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="therapeute_show", methods={"GET"})
     */
    public function show(Therapeute $therapeute): Response
    {

        return $this->render('therapeute/show.html.twig', [
            'therapeute' => $therapeute,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="therapeute_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Therapeute $therapeute): Response
    {
        $form = $this->createForm(TherapeuteType::class, $therapeute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file =$therapeute->getImage();


            $filename= $file->getClientOriginalName();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $therapeute->setPassword(md5($therapeute->getPassword()));

            $therapeute->setImage($filename);
            $therapeute->setPassword(md5($therapeute->getPassword()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('therapeute_index');
        }

        return $this->render('therapeute/edit.html.twig', [
            'therapeute' => $therapeute,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="therapeute_delete", methods={"POST"})
     */
    public function delete(Request $request, Therapeute $therapeute): Response
    {
        if ($this->isCsrfTokenValid('delete'.$therapeute->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($therapeute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('therapeute_index');
    }

}
