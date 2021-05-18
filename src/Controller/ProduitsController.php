<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Paniers;
use App\Entity\Produits;
use App\Entity\Promotion;
use App\Form\CommandesType;
use App\Form\ProduitsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
/**
 * @Route("/produits")
 */
class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();

        $produits = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6// Nombre de résultats par page
        );




        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
        ]);
    }
    
    /**
     * @Route("/shopJSON/add", name="shopJSON", methods={"POST","GET"})
     */
    public function shopJSON(Request $request, NormalizerInterface  $Normalizer): Response
    {


        $commande = new Commandes();


        $id = $request->get("idProduit");
        $quant = $request->get("Quant");
        $prix = $request->get("Prix");
        
        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\User::class)->findOneBy(
            ['email' => $a],
        );

        if(empty($this->verifPanier($user2->getCin())))
            {
                $panier = new Paniers();
                $panier->setCin($user2->getCin());
                $panier->setStatusPanier('En cours');

                $this->ajouterPanier($panier);

                foreach($this->verifPanier($user2->getCin()) as $key => $value)
                {
                    $commande->setIdPanier($value->getIdPanier());
                    $commande->setIdProduit($produit->getIdProduit());
                    $commande->setPrixU($produit->getPrix());
                }



                $this->ajouterCommande($commande);
            }else{
                foreach($this->verifPanier($user2->getCin()) as $key => $value)
                {
                    $commande->setIdPanier($value->getIdPanier());
                    $commande->setIdProduit($produit->getIdProduit());
                    $commande->setPrixU($produit->getPrix());
                }
                $this->ajouterCommande($commande);
            }

        $jsonContent = $Normalizer->normalize($commande,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));


    }

    /**
     * @Route("/{idProduit}/shop", name="shop_single", methods={"POST","GET"})
     */
    public function shop(Request $request): Response
    {

        $id = $request->get("idProduit");
        $produit = $this->getDoctrine()->getRepository(Produits::class)->find($id);

        $commande = new Commandes();
        $session=$request->getSession();
        $a=$session->get("email");
        $user2=$this->getDoctrine()->getRepository(\App\Entity\User::class)->findOneBy(
            ['email' => $a],
        );

        $form = $this->createForm(CommandesType::class, $commande);
        $form->add("Ajouter",SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if(empty($this->verifPanier($user2->getCin())))
            {
                $panier = new Paniers();
                $panier->setCin($user2->getCin());
                $panier->setStatusPanier('En cours');

                $this->ajouterPanier($panier);

                foreach($this->verifPanier($user2->getCin()) as $key => $value)
                {
                    $commande->setIdPanier($value->getIdPanier());
                    $commande->setIdProduit($produit->getIdProduit());
                    $commande->setPrixU($produit->getPrix());
                }



                $this->ajouterCommande($commande);
            }else{
                foreach($this->verifPanier($user2->getCin()) as $key => $value)
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
     * @Route("/listp", name="produits_list", methods={"GET"})
     */
    public function listp(): Response
    {


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $produits = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('produits/listp.html.twig', [
            'produits' => $produits,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.".date('m-d-Y_h;ia').".pdf", [
            "Attachment" => true
        ]);
    }
    
    
    /**
     * @Route("/afficherproduitsJSON", name="afficherproduitsJSON", methods={"GET"})
     */
    public function afficherproduitsJSON(Request $request, PaginatorInterface $paginator, NormalizerInterface  $Normalizer): Response
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


        $jsonContent = $Normalizer->normalize($produits,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/AllProduits", name="AllProduits")
     */
    public function AllProduits(NormalizerInterface  $Normalizer): Response
    {
        $donnees = $this->getDoctrine()
            ->getRepository(Produits::class)
            ->findAll();


        $promotions = $this->getDoctrine()
            ->getRepository(Promotion::class)
            ->findAll();

        $jsonContent = $Normalizer->normalize($donnees,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/AllPromos", name="AllPromos")
     */
    public function AllPromos(NormalizerInterface  $Normalizer): Response
    {


        $promotions = $this->getDoctrine()
            ->getRepository(Promotion::class)
            ->findAll();

        $jsonContent = $Normalizer->normalize($promotions,'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/afficherproduits", name="afficherproduits_index", methods={"GET"})
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
            6 // Nombre de résultats par page
        );

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


            $file = $form->get('image')->getData();
            $fileName= $file->getClientOriginalName();

            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }


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

    public function ajouterCommande($commande)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();
    }
}
