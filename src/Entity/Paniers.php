<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paniers
 *
 * @ORM\Table(name="paniers")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\NotBlank (message="Ce champ est obligatoire")
     *
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
     * @Assert\NotBlank (message="Ce champ est obligatoire")
     */
    private $statusPanier;

    /**
     * Paniers constructor.
     */
    public function __construct()
    {
        $this->dateC = new \DateTime();
    }

    /**
     * @return int
     */
    public function getIdPanier(): int
    {
        return $this->idPanier;
    }

    /**
     * @param int $idPanier
     */
    public function setIdPanier(int $idPanier): void
    {
        $this->idPanier = $idPanier;
    }

    /**
     * @return int|null
     */
    public function getCin(): ?int
    {
        return $this->cin;
    }

    /**
     * @param int|null $cin
     */
    public function setCin(?int $cin): void
    {
        $this->cin = $cin;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateC(): ?\DateTime
    {
        return $this->dateC;
    }

    /**
     * @param \DateTime|null $dateC
     */
    public function setDateC(?\DateTime $dateC): void
    {
        $this->dateC = $dateC;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateU()
    {
        return $this->dateU;
    }

    /**
     * @param \DateTime|null $dateU
     */
    public function setDateU($dateU): void
    {
        $this->dateU = $dateU;
    }

    /**
     * @return string|null
     */
    public function getStatusPanier(): ?string
    {
        return $this->statusPanier;
    }

    /**
     * @param string|null $statusPanier
     */
    public function setStatusPanier(?string $statusPanier): void
    {
        $this->statusPanier = $statusPanier;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->dateC = new \DateTime();
        $this->dateU = new \DateTime();
    }


    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue(): void
    {
        $this->dateU = new \DateTime();
    }
}
