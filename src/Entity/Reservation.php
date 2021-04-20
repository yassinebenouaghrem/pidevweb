<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="App\Repository\ResconsRepository")
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
     * @var string
     * @ORM\Column(name="cintherapeute", type="string", length=255, nullable=false)
     */
    private $cintherapeute;
    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Assert\NotBlank(message="type doit etre remplis")


     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;
    /**
     * @var string
     * @Assert\NotBlank(message="message doit etre remplis")


     * @ORM\Column(name="message", type="string", length=255, nullable=false)
     */
    private $message;


    public function getMessage()
    {
        return $this->message;
    }


    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getCintherapeute()
    {
        return $this->cintherapeute;
    }


    public function setCintherapeute(string $cintherapeute)
    {
        $this->cintherapeute = $cintherapeute;
    }
    /**
     * @var string

     * @ORM\Column(name="heure", type="string", length=250, nullable=false)
     */
    private $heure;
    /**
     * @var string

     * @ORM\Column(name="heurefin", type="string", length=250, nullable=false)
     */
    private $heurefin;
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
     * @return int
     */
    public function getIdreservation(): int
    {
        return $this->idreservation;
    }

    /**
     * @param int $idreservation
     * @return Reservation
     */
    public function setIdreservation(int $idreservation): Reservation
    {
        $this->idreservation = $idreservation;
        return $this;
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
     * @return Reservation
     */
    public function setIdconsultation(?int $idconsultation): Reservation
    {
        $this->idconsultation = $idconsultation;
        return $this;
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
     * @return Reservation
     */
    public function setIdclient(?int $idclient): Reservation
    {
        $this->idclient = $idclient;
        return $this;
    }


    public function getDate()
    {
        return $this->date;
    }


    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }


    public function getHeure()
    {
        return $this->heure;
    }


    public function setHeure(string $heure)
    {
        $this->heure = $heure;
        return $this;
    }
    public function getHeurefin()
    {
        return $this->heurefin;
    }


    public function setHeurefin(string $heurefin)
    {
        $this->heurefin = $heurefin;
        return $this;
    }
    public function getEtat()
    {
        return $this->etat;
    }


    public function setEtat(?string $etat){
        $this->etat = $etat;
        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }


    public function setImage(?string $image)
    {
        $this->image = $image;
        return $this;
    }


}
