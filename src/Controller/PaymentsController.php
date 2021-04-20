<?php

namespace App\Controller;

use App\Entity\Payments;
use App\Form\PaymentsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payments")
 */
class PaymentsController extends AbstractController
{
    /**
     * @Route("/", name="payments_index", methods={"GET"})
     */
    public function index(): Response
    {
        $payments = $this->getDoctrine()
            ->getRepository(Payments::class)
            ->findAll();

        return $this->render('payments/index.html.twig', [
            'payments' => $payments,
        ]);
    }

    /**
     * @Route("/new", name="payments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $payment = new Payments();
        $form = $this->createForm(PaymentsType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('payments_index');
        }

        return $this->render('payments/new.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPayment}", name="payments_show", methods={"GET"})
     */
    public function show(Payments $payment): Response
    {
        return $this->render('payments/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{idPayment}/edit", name="payments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Payments $payment): Response
    {
        $form = $this->createForm(PaymentsType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payments_index');
        }

        return $this->render('payments/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPayment}/delete", name="payments_delete", methods={"GET","POST"})
     */
    public function delete(Request $request): Response
    {
        $id = $request->get("idPayment");
        $payment = $this->getDoctrine()->getRepository(Payments::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($payment);
        $em->flush();

        return $this->redirectToRoute('payments_index');
    }
}
