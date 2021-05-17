<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups("post:read")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $idp;

    /**
     * @var int
     *
     * @ORM\Column(name="valP", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $valp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateD", type="date", nullable=false)
     * @Groups("post:read")
     */
    private $dated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateF", type="date", nullable=false)
     * @Groups("post:read")
     */
    private $datef;

    /**
     * Promotion constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId(): int
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
    public function getIdp(): ?int
    {
        return $this->idp;
    }

    /**
     * @param int $idp
     */
    public function setIdp(int $idp): void
    {
        $this->idp = $idp;
    }

    /**
     * @return int
     */
    public function getValp(): ?int
    {
        return $this->valp;
    }

    /**
     * @param int $valp
     */
    public function setValp(int $valp): void
    {
        $this->valp = $valp;
    }

    /**
     * @return \DateTime
     */
    public function getDated(): ?\DateTime
    {
        return $this->dated;
    }

    /**
     * @param \DateTime $dated
     */
    public function setDated(\DateTime $dated): void
    {
        $this->dated = $dated;
    }

    /**
     * @return \DateTime
     */
    public function getDatef(): ?\DateTime
    {
        return $this->datef;
    }

    /**
     * @param \DateTime $datef
     */
    public function setDatef(\DateTime $datef): void
    {
        $this->datef = $datef;
    }


}
