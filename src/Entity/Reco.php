<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reco
 *
 * @ORM\Table(name="reco")
 * @ORM\Entity
 */
class Reco
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=30, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=300, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="ecrivain", type="string", length=30, nullable=false)
     */
    private $ecrivain;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=90, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;


}
