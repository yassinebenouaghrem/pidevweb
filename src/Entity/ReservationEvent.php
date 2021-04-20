<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\Column(name="id_client", type="integer", nullable=false)
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
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     */
    private $nbPlace;

    /**
     * @var float
     *
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
     * ReservationEvent constructor.
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


}
