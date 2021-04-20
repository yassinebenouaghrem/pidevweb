<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity
 */
class Consultation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idtherapeute", type="integer", nullable=false)
     */
    private $idtherapeute;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="emplacement", type="string", length=255, nullable=false)
     */
    private $emplacement;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * Consultation constructor.
     * @param int $id
     * @param int $idtherapeute
     * @param string $titre
     * @param string $description
     * @param string $emplacement
     * @param float $prix
     * @param string $image
     */
    public function __construct(int $id, int $idtherapeute, string $titre, string $description, string $emplacement, float $prix, string $image)
    {
        $this->id = $id;
        $this->idtherapeute = $idtherapeute;
        $this->titre = $titre;
        $this->description = $description;
        $this->emplacement = $emplacement;
        $this->prix = $prix;
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIdtherapeute(): ?int
    {
        return $this->idtherapeute;
    }

    /**
     * @param int $idtherapeute
     */
    public function setIdtherapeute(int $idtherapeute): void
    {
        $this->idtherapeute = $idtherapeute;
    }

    /**
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    /**
     * @param string $emplacement
     */
    public function setEmplacement(string $emplacement): void
    {
        $this->emplacement = $emplacement;
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

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }


}
