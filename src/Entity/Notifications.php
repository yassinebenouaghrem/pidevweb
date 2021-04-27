<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifications
 *
 * @ORM\Table(name="notifications")
 * @ORM\Entity
 */
class Notifications
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
     * @var string|null
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=true)
     */
    private $etat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="motif", type="string", length=200, nullable=true)
     */
    private $motif;

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
     * @return string|null
     */
    public function getEtat(): ?string
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

    /**
     * @return string|null
     */
    public function getMotif(): ?string
    {
        return $this->motif;
    }

    /**
     * @param string|null $motif
     */
    public function setMotif(?string $motif): void
    {
        $this->motif = $motif;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {

        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';


}
