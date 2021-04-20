<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/consultation")
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $consultations = $this->getDoctrine()
            ->getRepository(Consultation::class)
            ->findAll();

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations,
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
            $entityManager = $this->getDoctrine()->getManager();
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
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultation $consultation): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
