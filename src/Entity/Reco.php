<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reco
 *
 * @ORM\Table(name="reco")
 * @ORM\Entity
 */
class Reco
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=30, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ecrivain", type="string", length=30, nullable=false)
     */
    private $ecrivain;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=90, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * Reco constructor.
     * @param int $id
     * @param string $titre
     * @param string $description
     * @param string $ecrivain
     * @param string $image
     * @param string $type
     */
    public function __construct(int $id, string $titre, string $description, string $ecrivain, string $image, string $type)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->ecrivain = $ecrivain;
        $this->image = $image;
        $this->type = $type;
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
    public function getEcrivain(): ?string
    {
        return $this->ecrivain;
    }

    /**
     * @param string $ecrivain
     */
    public function setEcrivain(string $ecrivain): void
    {
        $this->ecrivain = $ecrivain;
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

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }


}
