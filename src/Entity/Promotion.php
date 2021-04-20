<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity
 * @UniqueEntity("idp",message="cet id est deja utilisé")
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
     * @ORM\Column(name="idP", type="integer", nullable=false, unique=true)
     *  @Assert\Type(
     *     type="integer",
     *     message="cet id {{ value }} est non valide {{ type }}."
     * )
     * @Assert\Positive(message="l'id doit etre supérieur a 0")
     *
     */
    private $idp;

    /**
     * @var int
     *
     * @ORM\Column(name="valP", type="integer", nullable=false)
     *  @Assert\Type(
     *     type="integer",
     *     message="la valeur de promotion {{ value }} est non valide {{ type }}."
     * )
     * @Assert\Positive(message="la valeur de promotion doit etre supérieur a 0")
     */
    private $valp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateD", type="date", nullable=false)
     *  @Assert\GreaterThan("today")(message="date invalide")
     */
    private $dated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateF", type="date", nullable=false)
     * @Assert\GreaterThan(propertyPath="dated")
     */
    private $datef;

    /**
     * Promotion constructor.
     * @param int $id
     * @param int $idp
     * @param int $valp
     * @param \DateTime $dated
     * @param \DateTime $datef
     */

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


    public function getDated()
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


    public function getDatef()
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
