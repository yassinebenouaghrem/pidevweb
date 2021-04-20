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

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function setIdPanier(?int $idPanier): self
    {
        $this->idPanier = $idPanier;

        return $this;
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function setIdProduit(?int $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getQuantitee(): ?int
    {
        return $this->quantitee;
    }

    public function setQuantitee(?int $quantitee): self
    {
        $this->quantitee = $quantitee;

        return $this;
    }

    public function getPrixU(): ?float
    {
        return $this->prixU;
    }

    public function setPrixU(?float $prixU): self
    {
        $this->prixU = $prixU;

        return $this;
    }


}
