<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produits
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity
 */
class Produits
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantitee", type="integer", nullable=false)
     */
    private $quantitee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Type", type="string", length=225, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="string", length=225, nullable=true)
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="Prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * Produits constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdProduit(): int
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit(int $idProduit): void
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getQuantitee(): ?int
    {
        return $this->quantitee;
    }

    /**
     * @param int $quantitee
     */
    public function setQuantitee(int $quantitee): void
    {
        $this->quantitee = $quantitee;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return float
     */
    public function getPrix(): ?float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }


}
