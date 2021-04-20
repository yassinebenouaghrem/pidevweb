<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity
 */
class Promotion
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
     * @ORM\Column(name="idP", type="integer", nullable=false)
     */
    private $idp;

    /**
     * @var int
     *
     * @ORM\Column(name="valP", type="integer", nullable=false)
     */
    private $valp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateD", type="date", nullable=false)
     */
    private $dated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateF", type="date", nullable=false)
     */
    private $datef;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function setIdp(int $idp): self
    {
        $this->idp = $idp;

        return $this;
    }

    public function getValp(): ?int
    {
        return $this->valp;
    }

    public function setValp(int $valp): self
    {
        $this->valp = $valp;

        return $this;
    }

    public function getDated(): ?\DateTimeInterface
    {
        return $this->dated;
    }

    public function setDated(\DateTimeInterface $dated): self
    {
        $this->dated = $dated;

        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeInterface $datef): self
    {
        $this->datef = $datef;

        return $this;
    }


}
