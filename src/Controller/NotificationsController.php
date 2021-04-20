<?php

namespace App\Controller;

use App\Entity\Notifications;
use App\Form\Notifications1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notifications")
 */
class NotificationsController extends AbstractController
{
    /**
     * @Route("/", name="notifications_index", methods={"GET"})
     */
    public function index(): Response
    {
        $notifications = $this->getDoctrine()
            ->getRepository(Notifications::class)
            ->findAll();

        return $this->render('notifications/index.html.twig', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * @Route("/new", name="notifications_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $notification = new Notifications();
        $form = $this->createForm(Notifications1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notification);
            $entityManager->flush();

            return $this->redirectToRoute('notifications_index');
        }

        return $this->render('notifications/new.html.twig', [
            'notification' => $notification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="notifications_show", methods={"GET"})
     */
    public function show(Notifications $notification): Response
    {
        return $this->render('notifications/show.html.twig', [
            'notification' => $notification,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="notifications_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Notifications $notification): Response
    {
        $form = $this->createForm(Notifications1Type::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notifications_index');
        }

        return $this->render('notifications/edit.html.twig', [
            'notification' => $notification,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="notifications_delete", methods={"POST"})
     */
    public function delete(Request $request, Notifications $notification): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notification->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($notification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('notifications_index');
    }
}
