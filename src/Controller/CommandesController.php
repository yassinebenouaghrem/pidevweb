<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commandes")
 */
class CommandesController extends AbstractController
{
    /**
     * @Route("/", name="commandes_index", methods={"GET"})
     */
    public function index(): Response
    {
        $commandes = $this->getDoctrine()
            ->getRepository(Commandes::class)
            ->findAll();

        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="commandes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('commandes_index');
        }

        return $this->render('commandes/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommande}", name="commandes_show", methods={"GET"})
     */
    public function show(Commandes $commande): Response
    {
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{idCommande}/edit", name="commandes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commandes $commande): Response
    {
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commandes_index');
        }

        return $this->render('commandes/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommande}/delete/", name="commandes_delete", methods={"GET","POST"})
     *
     */
    public function delete(Request $request): Response
    {
        $id = $request->get("idCommande");
        $commande = $this->getDoctrine()->getRepository(Commandes::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();


        return $this->redirectToRoute('commandes_index');
    }


    public function Ajouter_commande($commande)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();
    }
}
