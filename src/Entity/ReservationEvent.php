<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ReservationEvent
 *
 * @ORM\Table(name="reservation_event")
 * @ORM\Entity
 */
class ReservationEvent
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
     * @ORM\Column(name="id_organisateur", type="integer", nullable=false)
     */
    private $idOrganisateur;




    /**
     * @var int
     * @Assert\NotBlank(message="Veuillez saisir l'id du client")
     * @ORM\Column(name="id_client", type="integer", nullable=false)
     * @Assert\Type(
     *     type="integer",
     *     message="ID {{ value }} non valide {{ type }}."
     * )
     * @Assert\Positive(message="ce nombre doit etre positive")
     */
    private $idClient;

    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     */
    private $idEvent;

    /**
     * @var int
     * @Assert\NotBlank(message="Veuillez saisir le nombre de place")

     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     * @Assert\Type(
     *     type="integer",
     *     message="ID {{ value }} non valide {{ type }}."
     * )
     * @Assert\Positive(message="ce nombre doit etre positive")
     */
    private $nbPlace;

    /**
     * @var float
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_paiement", type="string", length=50, nullable=false)
     */
    private $modePaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;


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
    public function getIdOrganisateur(): ?int
    {
        return $this->idOrganisateur;
    }

    /**
     * @param int $idOrganisateur
     */
    public function setIdOrganisateur(int $idOrganisateur): void
    {
        $this->idOrganisateur = $idOrganisateur;
    }

    /**
     * @return int
     */
    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    /**
     * @param int $idClient
     */
    public function setIdClient(int $idClient): void
    {
        $this->idClient = $idClient;
    }

    /**
     * @return int
     */
    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    /**
     * @param int $idEvent
     */
    public function setIdEvent(int $idEvent): void
    {
        $this->idEvent = $idEvent;
    }

    /**
     * @return int
     */
    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    /**
     * @param int $nbPlace
     */
    public function setNbPlace(int $nbPlace): void
    {
        $this->nbPlace = $nbPlace;
    }

    /**
     * @return float
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getModePaiement(): ?string
    {
        return $this->modePaiement;
    }

    /**
     * @param string $modePaiement
     */
    public function setModePaiement(string $modePaiement): void
    {
        $this->modePaiement = $modePaiement;
    }

    /**
     * @return string
     */
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }



    /**
     * @var string
     * @ORM\Column(name="imageEvent", type="string", nullable=false)
     */
    private $imageEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="titreEvent", type="string", nullable=false)
     */
    private $titreEvent;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_event", type="date", nullable=false)
     */
    private $dateEvent;

    /**
     * @return \DateTime
     */
    public function getDateEvent(): \DateTime
    {
        return $this->dateEvent;
    }

    /**
     * @param \DateTime $dateEvent
     */
    public function setDateEvent(\DateTime $dateEvent): void
    {
        $this->dateEvent = $dateEvent;
    }

    /**
     * @return string
     */
    public function getImageEvent(): ?string
    {
        return $this->imageEvent;
    }

    /**
     * @param string $imageEvent
     */
    public function setImageEvent(string $imageEvent): void
    {
        $this->imageEvent = $imageEvent;
    }

    /**
     * @return string
     */
    public function getTitreEvent(): ?string
    {
        return $this->titreEvent;
    }

    /**
     * @param string $titreEvent
     */
    public function setTitreEvent(string $titreEvent): void
    {
        $this->titreEvent = $titreEvent;
    }

}
/*
    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement", inversedBy="reservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_event", referencedColumnName="id")
     * })
     */

/*
    private $event;
    public function getEvent(): ?Evenement
    {
        return $this->event;
    }

    public function setEvent(?Evenement $event): self
    {
        $this->event = $event;

        return $this;
    }*/


