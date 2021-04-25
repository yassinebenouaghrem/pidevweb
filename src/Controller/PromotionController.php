<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Notifications\CreationPromoNotification;
/**
 * @Route("/promotion")
 */
class PromotionController extends AbstractController
{


    /**
     * @Route("/", name="promotion_index", methods={"GET"})
     */
    public function index(): Response
    {
        $promotions = $this->getDoctrine()
            ->getRepository(Promotion::class)
            ->findAll();

        return $this->render('promotion/index.html.twig', [
            'promotions' => $promotions,
        ]);
    }

    /**
     * @Route("/new", name="promotion_new", methods={"GET","POST"})
     */
    public function new(Request $request,\Swift_Mailer $mailer): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message = (new \Swift_Message('Zenlife'))
                ->setFrom('rachid.chawech@esprit.tn')
                ->setTo('rachid.chawech@esprit.tn')
                ->setBody(
                    $this->renderView(
                        'emails/ajout_promo_notif.html.twig',[
                            'promotion' => $promotion,
                        ]
                    ),
                    'text/html'
                );

            $entityManager->persist($promotion);
            $entityManager->flush();

            $mailer->send($message);




            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="promotion_show", methods={"GET"})
     */
    public function show(Promotion $promotion): Response
    {
        return $this->render('promotion/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="promotion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Promotion $promotion): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotion_index');
        }

        return $this->render('promotion/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="promotion_delete", methods={"POST"})
     */
    public function delete(Request $request, Promotion $promotion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promotion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('promotion_index');
    }
}
