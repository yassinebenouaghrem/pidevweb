<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Payments
 *
 * @ORM\Table(name="payments", indexes={@ORM\Index(name="fk_pan_pay", columns={"ID_Panier"})})
 * @ORM\Entity
 */
class Payments
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Payment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idPayment;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_Panier", type="integer", nullable=true)
     * @Assert\NotBlank (message="Ce champ est obligatoire")
     * @Groups("post:read")
     */
    private $idPanier;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Prix_F", type="float", precision=10, scale=0, nullable=true)
     * @Assert\NotBlank (message="Ce champ est obligatoire")
     * @Groups("post:read")
     */
    private $prixF;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mode_payment", type="string", length=10, nullable=true)
     * @Assert\NotBlank (message="Ce champ est obligatoire")
     * @Groups("post:read")
     */
    private $modePayment;

    /**
     * Payments constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getIdPayment(): int
    {
        return $this->idPayment;
    }

    /**
     * @param int $idPayment
     */
    public function setIdPayment(int $idPayment): void
    {
        $this->idPayment = $idPayment;
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
     * @return float|null
     */
    public function getPrixF(): ?float
    {
        return $this->prixF;
    }

    /**
     * @param float|null $prixF
     */
    public function setPrixF(?float $prixF): void
    {
        $this->prixF = $prixF;
    }

    /**
     * @return string|null
     */
    public function getModePayment(): ?string
    {
        return $this->modePayment;
    }

    /**
     * @param string|null $modePayment
     */
    public function setModePayment(?string $modePayment): void
    {
        $this->modePayment = $modePayment;
    }


}
