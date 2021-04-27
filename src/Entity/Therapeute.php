<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* Therapeute
*

* @ORM\Entity
*/
class Therapeute
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *@Assert\NotBlank(message="remplir le champs CIN")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "cin doit contenir 8 chiffre",
     *      maxMessage = "cin doit contenir 8 chiffre",
     *     exactMessage="cin doit contenir 8 chiffre"
     * )
     *
     * @ORM\Column(name="cin", type="integer", nullable=false)
     */
    protected $cin;

    /**
     * @var string
     *@Assert\NotBlank(message="remplir le champs email")
     * @Assert\Email(
     *     message = "email '{{ value }}' n'est pas un email valide"
     * )
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    protected $email;

    /**
     * @var string
     *
     *@Assert\NotBlank(message="remplir le champs nom")
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    protected $nom;

    /**
     * @var string
     *@Assert\NotBlank(message="remplir le champs prenom")
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    protected $prenom;

    /**
     * @var string
     *
     *@Assert\NotBlank(message="remplir le champs mot de passe")
     *  @Assert\Length(
     *      min = 8,
     *      max = 30,
     *      minMessage = "mot de passe doit contenir au moins 8 carracteres",
     *      maxMessage = "mot de passe doit contenir au maximum 30 carracteres"
     * )
     * @ORM\Column(name="password", type="string", length=80, nullable=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    protected $type;

    /**
     * @var int|null
     *@Assert\NotBlank(message="remplir le champs tel")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "tel doit contenir 8 chiffre",
     *      maxMessage = "tel doit contenir 8 chiffre",
     *     exactMessage="tel doit contenir 8 chiffre"
     * )
     * @ORM\Column(name="numtel", type="integer", nullable=true)
     */
    private $numtel;


    /**
     * @var string|null
     *@Assert\NotBlank(message="remplir le champs adresse")
     *
     * @ORM\Column(name="adresse", type="string", length=30, nullable=true)
     */
    private $adresse;

    /**
     * @var string|null
     *@Assert\NotBlank(message="remplir le champs image")
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float", nullable=true)

     */
    private $lng;

    /**
     * @ORM\Column(type="float", nullable=true)

     */
    private $lat;

    /**
     * Therapeute constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng): void
    {
        $this->lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }




    /**
     * @return int|null
     */
    public function getNumtel()
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
     * @return string|null
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string|null $adresse
     */
    public function setAdresse(?string $adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage( $image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getId()
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
    public function getCin()
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
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNom()
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
    public function getPrenom()
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
    public function getPassword()
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
    public function getType()
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
     * @return string|null
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string|null $etat
     */
    public function setEtat(?string $etat): void
    {
        $this->etat = $etat;
    }






}
