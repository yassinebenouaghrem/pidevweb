<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Promotion;
use App\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/produits")
 */
class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_index", methods={"GET"})
     */
    public function index(): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();

        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
        ]);
    }
    /**
     * @Route("/afficherproduits", name="afficherproduits_index", methods={"GET"})
     */
    public function afficherproduits(): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();
        $promotions = $this->getDoctrine()
            ->getRepository(Promotion::class)
            ->findAll();
        return $this->render('produits/afficherproduits.html.twig', [
            'promotions'=>$promotions,
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/new", name="produits_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            $fileName = $form->get('image')->getData();




            $entityManager = $this->getDoctrine()->getManager();
            $produit->setImage($fileName);
            $entityManager->persist($produit);



            $entityManager->flush();



            return $this->redirectToRoute('produits_index');
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idProduit}", name="produits_show", methods={"GET"})
     */
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{idProduit}/edit", name="produits_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produits $produit): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produits_index');
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idProduit}", name="produits_delete", methods={"POST"})
     */
    public function delete(Request $request, Produits $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getIdProduit(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produits_index');
    }
}
