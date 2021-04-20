<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *  @ORM\Table(name="user")

 * @ORM\Entity
 */
class User
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
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=30, nullable=true)
     */
    protected $etat;
    /**
     * @var string
     *@Assert\NotBlank(message="remplir le champs mot de passe")
     *  @Assert\Length(
     *      min = 8,
     *      max = 30,
     *      minMessage = "mot de passe doit contenir au moins 8 carracteres",
     *      maxMessage = "mot de passe doit contenir au maximum 30 carracteres"
     * )
     */
    public  $password1;
    /**
     * @var string
     *@Assert\NotBlank(message="remplir le champs code")

     */
    public  $code;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }


    /**
     * @return string
     */
    public function getPassword1(): string
    {
        return $this->password1;
    }

    /**
     * @param string $password1
     */
    public function setPassword1(string $password1): void
    {
        $this->password1 = $password1;
    }




    /**
     * User constructor.
     */
    public function __construct()
    {
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
     * @return string
     */
    public function getEmail()
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


    public function getNom()
    {
        return $this->nom;
    }


    public function setNom(string $nom)
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
