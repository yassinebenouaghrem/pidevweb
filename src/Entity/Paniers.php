<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paniers
 *
 * @ORM\Table(name="paniers")
 * @ORM\Entity
 */
class Paniers
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPanier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cin", type="integer", nullable=true)
     */
    private $cin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_C", type="date", nullable=true)
     */
    private $dateC;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_U", type="date", nullable=true, options={"default"="`Date_C`"})
     */
    private $dateU = '`Date_C`';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Status_panier", type="string", length=10, nullable=true)
     */
    private $statusPanier;

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(?int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateC(): ?\DateTimeInterface
    {
        return $this->dateC;
    }

    public function setDateC(?\DateTimeInterface $dateC): self
    {
        $this->dateC = $dateC;

        return $this;
    }

    public function getDateU(): ?\DateTimeInterface
    {
        return $this->dateU;
    }

    public function setDateU(?\DateTimeInterface $dateU): self
    {
        $this->dateU = $dateU;

        return $this;
    }

    public function getStatusPanier(): ?string
    {
        return $this->statusPanier;
    }

    public function setStatusPanier(?string $statusPanier): self
    {
        $this->statusPanier = $statusPanier;

        return $this;
    }


}
