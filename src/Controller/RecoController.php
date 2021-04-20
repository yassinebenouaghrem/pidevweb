<?php

namespace App\Controller;

use App\Entity\Reco;
use App\Form\RecoType;
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
    public function index(): Response
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
            $entityManager = $this->getDoctrine()->getManager();
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
     * @Route("/{id}/edit", name="reco_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reco $reco): Response
    {
        $form = $this->createForm(RecoType::class, $reco);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
}
