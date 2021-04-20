<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idreservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreservation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idconsultation", type="integer", nullable=true)
     */
    private $idconsultation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idclient", type="integer", nullable=true)
     */
    private $idclient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="heure", type="string", length=250, nullable=false)
     */
    private $heure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=250, nullable=true, options={"default"="En attente de confirmation"})
     */
    private $etat = 'En attente de confirmation';

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=250, nullable=true)
     */
    private $image;

    /**
     * Reservation constructor.
     * @param int $idreservation
     * @param int|null $idconsultation
     * @param int|null $idclient
     * @param \DateTime $date
     * @param string $type
     * @param string $heure
     * @param null|string $etat
     * @param null|string $image
     */
    public function __construct(int $idreservation, ?int $idconsultation, ?int $idclient, \DateTime $date, string $type, string $heure, ?string $etat, ?string $image)
    {
        $this->idreservation = $idreservation;
        $this->idconsultation = $idconsultation;
        $this->idclient = $idclient;
        $this->date = $date;
        $this->type = $type;
        $this->heure = $heure;
        $this->etat = $etat;
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getIdreservation(): ?int
    {
        return $this->idreservation;
    }

    /**
     * @param int $idreservation
     */
    public function setIdreservation(int $idreservation): void
    {
        $this->idreservation = $idreservation;
    }

    /**
     * @return int|null
     */
    public function getIdconsultation(): ?int
    {
        return $this->idconsultation;
    }

    /**
     * @param int|null $idconsultation
     */
    public function setIdconsultation(?int $idconsultation): void
    {
        $this->idconsultation = $idconsultation;
    }

    /**
     * @return int|null
     */
    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    /**
     * @param int|null $idclient
     */
    public function setIdclient(?int $idclient): void
    {
        $this->idclient = $idclient;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
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

    /**
     * @return string
     */
    public function getHeure(): ?string
    {
        return $this->heure;
    }

    /**
     * @param string $heure
     */
    public function setHeure(string $heure): void
    {
        $this->heure = $heure;
    }

    /**
     * @return null|string
     */
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    /**
     * @param null|string $etat
     */
    public function setEtat(?string $etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return null|string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param null|string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }


}
