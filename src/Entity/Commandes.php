<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Le numéro du panier est obligatoire")
     */
    private $idPanier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_Produit", type="integer", nullable=true)
     * @Assert\NotBlank(message="Le numéro du produit est obligatoire")
     */
    private $idProduit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Quantitee", type="integer", nullable=true)
     * @Assert\NotBlank(message="La quantité du produit est manquante")
     */
    private $quantitee;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Prix_U", type="float", precision=10, scale=0, nullable=true)
     * @Assert\NotBlank(message="Le prix est obligatoire")
     */

    private $prixU;

    /**
     * Commandes constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdCommande(): int
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
