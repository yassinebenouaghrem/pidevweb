<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="App\Repository\ConsultationRepository")
 */
class Consultation
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
     * @ORM\Column(name="idtherapeute", type="integer", nullable=false)
     */
    private $idtherapeute;

    /**
     * @var string
     * @Assert\NotBlank(message="titre doit etre remplis")
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**

     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="description doit etre remplis")

     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank(message="emplacement doit etre remplis")
     * @ORM\Column(name="emplacement", type="string", length=255, nullable=false)
     */
    private $emplacement;

    /**
     * @var float
     * @Assert\Positive

     * @Assert\NotBlank(message="prix doit etre remplis")
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     * @ORM\Column(name="image", type="string", length=255, nullable=true)

     */
    private $image;
    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     * @Assert\NotBlank(message="veuillez choisir une heure de debut")
     * @Assert\Expression(
     *     "this.getHeurefin() > this.getHeuredeb()",
     *     message="Heure debut doit etre infereur a lheure fin"
     * )
     * @ORM\Column(name="heuredeb", type="string", length=250, nullable=false)
     */
    private $heuredeb;

    /**
     * @var string
* @ORM\Column(name="etat", type="string", length=250, nullable=false,options={"default"="Disponible"})
*/
    private $etat;

    public function getEtat()
    {
        return $this->etat;
    }


    public function setEtat(string $etat)
    {
        $this->etat = $etat;
    }
    public function getDate()
    {
        return $this->date;
    }


    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }


    public function getHeuredeb()
    {
        return $this->heuredeb;
    }


    public function setHeuredeb(string $heuredeb)
    {
        $this->heuredeb = $heuredeb;
    }


    public function getHeurefin()
    {
        return $this->heurefin;
    }


    public function setHeurefin(string $heurefin)
    {
        $this->heurefin = $heurefin;
    }

    /**
     * @var string
     * @Assert\NotNull()
     * @Assert\NotBlank(message="veuillez choisir une heure de fin")
     * @Assert\Expression(
     *     "this.getHeurefin() >this.getHeuredeb()",
     *     message="Heure fin doit etre superieur a lheure debut"
     * )
     * @ORM\Column(name="heurefin", type="string", length=250, nullable=false)
     */
    private $heurefin;
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
    public function getIdtherapeute()
    {
        return $this->idtherapeute;
    }

    /**
     * @param int $idtherapeute
     */
    public function setIdtherapeute(int $idtherapeute): void
    {
        $this->idtherapeute = $idtherapeute;
    }

    /**
     * @return string
     */
    public function getTitre()
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
    public function getDescription()
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
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * @param string $emplacement
     */
    public function setEmplacement(string $emplacement): void
    {
        $this->emplacement = $emplacement;
    }
    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }


    public function getImage()
    {
        return $this->image;
    }


    public function setImage(string $image)
    {
        $this->image = $image;
        return $this;

    }


}
