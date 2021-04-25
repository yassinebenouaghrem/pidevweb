<?php

namespace App\Controller;

use App\Entity\Paniers;
use App\Form\PaniersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paniers")
 */
class PaniersController extends AbstractController
{
    /**
     * @Route("/", name="paniers_index", methods={"GET"})
     */
    public function index(): Response
    {
        $paniers = $this->getDoctrine()
            ->getRepository(Paniers::class)
            ->findAll();

        return $this->render('paniers/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    /**
     * @Route("/new", name="paniers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $panier = new Paniers();
        $form = $this->createForm(PaniersType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panier);
            $entityManager->flush();
            return $this->redirectToRoute('paniers_index');
        }

        return $this->render('paniers/new.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPanier}", name="paniers_show", methods={"GET"})
     */
    public function show(Paniers $panier): Response
    {
        return $this->render('paniers/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    /**
     * @Route("/{idPanier}/edit", name="paniers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paniers $panier): Response
    {
        $form = $this->createForm(PaniersType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paniers_index');
        }

        return $this->render('paniers/edit.html.twig', [
            'panier' => $panier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPanier}/delete", name="paniers_delete", methods={"GET","POST"})
     */
    public function delete(Request $request): Response
    {
        $id = $request->get("idPanier");
        $panier = $this->getDoctrine()->getRepository(Paniers::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($panier);
        $em->flush();

        return $this->redirectToRoute('paniers_index');
    }


    /**
     * @Route("/stat", name="stat", methods={"GET","POST"})
     */
    public function stat(): Response
    {


        return $this->render('paniers/Statistique.html.twig');
    }


    public function Ajouter_panier($panier)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();
    }


}
