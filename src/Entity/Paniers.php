<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paniers
 *
 * @ORM\Table(name="paniers")
 * @ORM\Entity
 */
class Paniers
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPanier;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cin", type="integer", nullable=true)
     */
    private $cin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_C", type="date", nullable=true)
     */
    private $dateC;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Date_U", type="date", nullable=true, options={"default"="`Date_C`"})
     */
    private $dateU = '`Date_C`';

    /**
     * @var string|null
     *
     * @ORM\Column(name="Status_panier", type="string", length=10, nullable=true)
     */
    private $statusPanier;


}
