<?php

namespace App\Controller;
require 'C:/xampp/htdocs/ZenLife/vendor/autoload.php';

use App\Controller\CommandesController;
use App\Entity\Commandes;
use App\Entity\Paniers;
use App\Entity\Payments;
use App\Entity\Produits;
use App\Entity\Promotion;
use App\Entity\TwilioSMS;
use App\Controller\PaniersController;
use App\Controller\PaymentsController;
use App\Form\CommandesType;
use App\Form\FrontType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index(): Response
    {
        $produits = $this->Afficher_Produit();
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'produits'=>$produits,
        ]);
    }

    /**
     * @Route("/{idProduit}/front/shop", name="shop_single", methods={"POST","GET"})
     */
    public function shop(Request $request): Response
    {

        $id = $request->get("idProduit");
        $produit = $this->getDoctrine()->getRepository(Produits::class)->find($id);

        $commande = new Commandes();


        $form = $this->createForm(CommandesType::class, $commande);
        $form->add("Ajouter",SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if(empty($this->verifPanier(111111)))
            {
                $panier = new Paniers();
                $panier->setCin(111111);
                $panier->setStatusPanier('En cours');

                $this->ajouterPanier($panier);

                foreach($this->verifPanier(111111) as $key => $value)
                {
                    $commande->setIdPanier($value->getIdPanier());
                    $commande->setIdProduit($produit->getIdProduit());
                    $commande->setPrixU($produit->getPrix());
                }



                $this->ajouterCommande($commande);
            }else{
                foreach($this->verifPanier(111111) as $key => $value)
                {
                    $commande->setIdPanier($value->getIdPanier());
                    $commande->setIdProduit($produit->getIdProduit());
                    $commande->setPrixU($produit->getPrix());
                }
                $this->ajouterCommande($commande);
            }


            return $this->redirectToRoute('cart');
        }


        return $this->render('front/shop_single.html.twig', [
            'produit' => $produit,
            'quantitee' => 1,
            'form'=>$form->createView(),

        ]);

    }

    /**
     * @Route("/front/cart", name="cart", methods={"GET"})
     */
    public function cart(): Response
    {
        $idPanier = 0;
        foreach($this->verifPanier(111111) as $key => $value)
        {
            $idPanier = $value->getIdPanier();
        }

        $commandes = $this->Afficher_Commande($idPanier);



        return $this->render('front/cart.html.twig',[
            'commandes'=>$commandes,
        ]);

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
     * @Route("/{idCommande}/front/delete", name="delete_commande", methods={"GET"})
     */
    public function delete(Request $request): Response
    {
        $id = $request->get("idCommande");
        $this->supprimerCommande($id);

        $idPanier = 0;
        foreach($this->verifPanier(111111) as $key => $value)
        {
            $idPanier = $value->getIdPanier();
        }

        $commandes = $this->Afficher_Commande($idPanier);

        return $this->render('front/cart.html.twig',[
            'commandes'=>$commandes,
        ]);

    }


    /**
     * @Route("/front/checkout", name="checkout", methods={"GET"})
     */
    public function checkout(): Response
    {

        $idPanier = 0;
        foreach($this->verifPanier(111111) as $key => $value)
        {
            $idPanier = $value->getIdPanier();
        }

        return $this->render('front/checkout.html.twig',[
            'commandes' => $this->Afficher_Commande($idPanier),
            'totale' => $this->calcueTotale($idPanier),
            'idPanier' => $idPanier,
        ]);

    }

    /**
     * @Route("/{idPanier}/front/thankyou", name="thankyou", methods={"GET"})
     */
    public function thank(Request $request): Response
    {

        $id = $request->get("idPanier");
        $payment = new Payments();

        $payment->setIdPanier($id);
        $payment->setModePayment("Espèce");
        $payment->setPrixF($this->calcueTotale($id));

        $this->modifierQuantiter($id);

        $this->modifierPanier($id);
        $this->ajouterPayment($payment);

        $msg = "Votre commande n°".$id." a été enregistrer avec succées, vous la receverez dans les prochains délais.\n\nZenlife";
        $this->SMS('+13392040620','+21652836953',$msg);

        return $this->render('front/thankyou.html.twig');

    }

    /**
     * @Route("/front/afficherproduits", name="afficherproduits_index", methods={"GET"})
     */
    public function afficherproduits(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();
        $produits = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt(
                'page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        $promotions = $this->getDoctrine()
            ->getRepository(Promotion::class)
            ->findAll();
        return $this->render('produits/afficherproduits.html.twig', [
            'promotions'=>$promotions,
            'produits' => $produits,
        ]);
    }

    public function Afficher_Produit()
    {
        $liste = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();

        return $liste;
    }


    public function Afficher_Commande($id)
    {
        $liste = $this->getDoctrine()->getRepository(Commandes::class)
            ->findBy([
                'idPanier'=>$id,
            ]);
        return $liste;
    }


    public function SMS($twilio_number,$rec,$message)
    {

        $twilio = new TwilioSMS();
        // A Twilio number you own with SMS capabilities


        $client = new Client($twilio->getAccountSid(), $twilio->getAuthToken());
        $client->messages->create(
        // Where to send a text message (your cell phone?)
            $rec,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
    }

    public function verifPanier($id_usr)
    {
        $liste = $this->getDoctrine()
            ->getRepository(Paniers::class)
            ->findBy([
                'cin' => $id_usr,
                'statusPanier' => 'En cours',
            ]);

        return $liste;
    }

    public function ajouterPanier($panier)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($panier);
        $entityManager->flush();
    }

    public function modifierPanier($id)
    {
        $panier = $this->getDoctrine()->getRepository(Paniers::class)->find($id);
        $panier->setStatusPanier('Payer');

        $em = $this->getDoctrine()->getManager();
        $em->flush();
    }



    public function ajouterCommande($commande)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();
    }

    public function modifierCommande()
    {}

    public function supprimerCommande($id)
    {
        $commande = $this->getDoctrine()->getRepository(Commandes::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();
    }

    public function ajouterPayment($payment)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($payment);
        $entityManager->flush();
    }

    public function calcueTotale($idPanier)
    {
        $totale = 0;
        $liste = $this->Afficher_Commande($idPanier);

        foreach($liste as $key => $value)
        {
            $totale = ($value->getQuantitee() * $value->getPrixU()) + $totale;
        }

        return $totale;
    }

    public function getProduit($id)
    {
        return $this->getDoctrine()->getRepository(Produits::class)->find($id);
    }

    public function modifierQuantiter($id)
    {
        $commandes = $this->Afficher_Commande($id);

        foreach($commandes as $key => $commande)
        {
            $idProduit = $commande->getIdProduit();
            $produit = $this->getProduit($idProduit);

            $quant = $produit->getQuantitee() - $commande->getQuantitee();
            $produit->setQuantitee($quant);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }
    }









}
