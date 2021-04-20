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

    /**
     * Commandes constructor.
     * @param int $idCommande
     * @param int|null $idPanier
     * @param int|null $idProduit
     * @param int|null $quantitee
     * @param float|null $prixU
     */
    public function __construct(int $idCommande, ?int $idPanier, ?int $idProduit, ?int $quantitee, ?float $prixU)
    {
        $this->idCommande = $idCommande;
        $this->idPanier = $idPanier;
        $this->idProduit = $idProduit;
        $this->quantitee = $quantitee;
        $this->prixU = $prixU;
    }

    /**
     * @return int
     */
    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    /**
     * @param int $idCommande
     */
    public function setIdCommande(int $idCommande): void
    {
        $this->idCommande = $idCommande;
    }

    /**
     * @return int|null
     */
    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    /**
     * @param int|null $idPanier
     */
    public function setIdPanier(?int $idPanier): void
    {
        $this->idPanier = $idPanier;
    }

    /**
     * @return int|null
     */
    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    /**
     * @param int|null $idProduit
     */
    public function setIdProduit(?int $idProduit): void
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return int|null
     */
    public function getQuantitee(): ?int
    {
        return $this->quantitee;
    }

    /**
     * @param int|null $quantitee
     */
    public function setQuantitee(?int $quantitee): void
    {
        $this->quantitee = $quantitee;
    }

    /**
     * @return float|null
     */
    public function getPrixU(): ?float
    {
        return $this->prixU;
    }

    /**
     * @param float|null $prixU
     */
    public function setPrixU(?float $prixU): void
    {
        $this->prixU = $prixU;
    }


}
