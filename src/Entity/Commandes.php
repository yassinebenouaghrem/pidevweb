<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes", indexes={@ORM\Index(name="fk_pan_com", columns={"ID_Panier"})})
 * @ORM\Entity
 */
class Commandes
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_Panier", type="integer", nullable=true)
     */
    private $idPanier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_Produit", type="integer", nullable=true)
     */
    private $idProduit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Quantitee", type="integer", nullable=true)
     */
    private $quantitee;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Prix_U", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixU;


}
