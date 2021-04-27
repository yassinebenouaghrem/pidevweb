<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * Evenement
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 * @ORM\Table(name="evenement")
 */
class Evenement
{

    /**
     * @Assert\Type(type="App\Entity\ReservationEvent")
     * @Assert\Valid
     */
    protected $ReservationEvent;

    /**
     * @return mixed
     */
    public function getReservationEvent() : ?ReservationEvent
    {
        return $this->ReservationEvent;
    }

    /**
     * @param mixed $ReservationEvent
     */
    public function setReservationEvent(?ReservationEvent $ReservationEvent)
    {
        $this->ReservationEvent = $ReservationEvent;
    }


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
     * @ORM\Column(name="id_organisateur", type="integer", nullable=false)
     */


    private $idOrganisateur;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="titre", type="string", length=50, nullable=false)
     */
    private $titre;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="description", type="string", length=300, nullable=false)
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="lieu", type="string", length=100, nullable=false)
     */
    public $lieu;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="date_event", type="date", nullable=false)
     */
    private $dateEvent;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @var float
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="tarif", type="float", precision=10, scale=0, nullable=false)
     */
    private $tarif;

    /**
     * @var int
     * @Assert\NotBlank(message="Ce champs doit etre remplis")
     * @ORM\Column(name="capacite", type="integer", nullable=false)

     */
    private $capacite;

    /**
     * @var int
     * @ORM\Column(name="nb_reservation", type="integer", nullable=false)
     */
    private $nbReservation;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
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
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    /**
     * @param string $lieu
     */
    public function setLieu(string $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return \DateTime
     */
    public function getDateEvent(): ?\DateTime
    {
        return $this->dateEvent;
    }

    /**
     * @param DateTime $dateEvent
     */
    public function setDateEvent( $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage( $image)
    {
        $this->image = $image;
    }

    /**
     * @return float
     */
    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    /**
     * @param float $tarif
     */
    public function setTarif(float $tarif): void
    {
        $this->tarif = $tarif;
    }

    /**
     * @return int
     */
    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    /**
     * @param int $capacite
     */
    public function setCapacite(int $capacite): void
    {
        $this->capacite = $capacite;
    }

    /**
     * @return int
     */
    public function getNbReservation(): ?int
    {
        return $this->nbReservation;
    }

    /**
     * @param int $nbReservation
     */
    public function setNbReservation(int $nbReservation): void
    {
        $this->nbReservation = $nbReservation;
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
     * @ORM\OneToMany(targetEntity=ReservationEvent::class, mappedBy="reservation", cascade={"persist"})
     */
    private $reservation;
    public function __construct()
    {
        $this->reservation = new ArrayCollection();
    }
    /**
     * @return Collection|Comment[]
     */
    public function getreservation(): Collection
    {
        return $this->reservation;
    }
    public function setreservation(ReservationEvent $reservation): self
    {
        if (!$this->reservation->contains($reservation)) {
            $this->reservation[] = $reservation;
            $reservation->setPost($this);
        }

        return $this;
    }

}
