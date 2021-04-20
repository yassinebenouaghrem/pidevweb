<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $idPayment;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_Panier", type="integer", nullable=true)
     */
    private $idPanier;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Prix_F", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixF;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mode_payment", type="string", length=10, nullable=true)
     */
    private $modePayment;

    /**
     * Payments constructor.
     * @param int $idPayment
     * @param int|null $idPanier
     * @param float|null $prixF
     * @param null|string $modePayment
     */
    public function __construct(int $idPayment, ?int $idPanier, ?float $prixF, ?string $modePayment)
    {
        $this->idPayment = $idPayment;
        $this->idPanier = $idPanier;
        $this->prixF = $prixF;
        $this->modePayment = $modePayment;
    }

    /**
     * @return int
     */
    public function getIdPayment(): ?int
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
     * @return null|string
     */
    public function getModePayment(): ?string
    {
        return $this->modePayment;
    }

    /**
     * @param null|string $modePayment
     */
    public function setModePayment(?string $modePayment): void
    {
        $this->modePayment = $modePayment;
    }


}
