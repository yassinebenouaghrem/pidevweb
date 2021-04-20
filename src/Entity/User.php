<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="cin", type="integer", nullable=false)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numtel", type="integer", nullable=true)
     */
    private $numtel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=30, nullable=true)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=30, nullable=true)
     */
    private $etat;

    /**
     * User constructor.
     * @param int $id
     * @param int $cin
     * @param string $email
     * @param string $nom
     * @param string $prenom
     * @param string $password
     * @param string $type
     * @param int|null $numtel
     * @param null|string $adresse
     * @param null|string $image
     * @param null|string $etat
     */
    public function __construct(int $id, int $cin, string $email, string $nom, string $prenom, string $password, string $type, ?int $numtel, ?string $adresse, ?string $image, ?string $etat)
    {
        $this->id = $id;
        $this->cin = $cin;
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->password = $password;
        $this->type = $type;
        $this->numtel = $numtel;
        $this->adresse = $adresse;
        $this->image = $image;
        $this->etat = $etat;
    }

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
    public function getCin(): ?int
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin(int $cin): void
    {
        $this->cin = $cin;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
     * @return int|null
     */
    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    /**
     * @param int|null $numtel
     */
    public function setNumtel(?int $numtel): void
    {
        $this->numtel = $numtel;
    }

    /**
     * @return null|string
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param null|string $adresse
     */
    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
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


}
