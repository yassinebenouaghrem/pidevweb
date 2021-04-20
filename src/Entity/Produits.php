<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Nom est requis")
     * @Assert\Type(
     *     type="alpha",
     *     message="Ce nom {{ value }} est non valide ."
     * )
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantitee", type="integer", nullable=false)
     * @Assert\NotBlank(message="Quantité est requis")
     * @Assert\Type(
     *     type="integer",
     *     message="cette quantite {{ value }} est non valide {{ type }}."
     * )
     * @Assert\Positive(message="ce nombre doit etre supérieur a 0")
     */
    private $quantitee;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=225, nullable=false)
     * @Assert\NotBlank(message="Type est requis")
     * @Assert\Type(
     *     type="alpha",
     *     message="Ce type {{ value }} est non valide ."
     * )
     */
    private $type;

    /**
     * @var string
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     * @ORM\Column(name="image", type="string", length=255, nullable=true)

     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="Prix", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Prix est requis")
     * @Assert\Type(
     *     type="float",
     *     message="Ce prix {{ value }} est non valide{{ type }}."
     * )
     * @Assert\Positive(message="ce nombre doit etre supérieur a 0")
     */
    private $prix;

    /**
     * Produits constructor.
     * @param int $idProduit
     * @param string $nom
     * @param int $quantitee
     * @param null|string $type
     * @param null|string $image
     * @param float $prix
     */

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit(int $idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getQuantitee()
    {
        return $this->quantitee;
    }

    /**
     * @param int $quantitee
     */
    public function setQuantitee(int $quantitee)
    {
        $this->quantitee = $quantitee;
    }

    /**
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type)
    {
        $this->type = $type;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix)
    {
        $this->prix = $prix;
    }


}
