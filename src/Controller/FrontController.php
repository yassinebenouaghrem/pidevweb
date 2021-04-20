<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\FrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index(): Response
    {
        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'produits'=>$produits,
        ]);
    }

    /**
     * @Route("/{idProduit}/front/shop", name="shop_single", methods={"GET"})
     */
    public function shop(Request $request): Response
    {

        $id = $request->get("idProduit");
        $produit = $this->getDoctrine()->getRepository(Produits::class)->find($id);


        return $this->render('front/shop_single.html.twig', [
            'produit' => $produit,
            'quantitee' => 1,

        ]);

    }

    /**
     * @Route("/front/cart", name="cart", methods={"GET"})
     */
    public function cart(): Response
    {

        $this->addFlash('success', 'Article ajouter avec succée!');


        return $this->render('front/cart.html.twig');

    }

    /**
     * @Route("/{idProduit}{quant}/front/cart", name="addcart", methods={"GET"})
     */
    public function addcart(Request $request): Response
    {
        $id = $request->get("idProduit");
        $quantitee = $request->get("quant");
        $this->addFlash('success', 'Article ajouter avec succée! id '.$id.' quant '.$quantitee);


        return $this->render('front/cart.html.twig');

    }


    /**
     * @Route("/front/checkout", name="checkout")
     */
    public function checkout(): Response
    {

        return $this->render('front/checkout.html.twig');

    }
}
