<?php

namespace App\Entity;

class FitreRecherche{


    /**
     * @var string|null
     */
    private $lieu;

    /**
     * @var string|null
     */
    private $TypeEvent;




    /**
     * @var int|null
     */
    private $PrixMax;

    /**
     * @return string|null
     */
    public function getTypeEvent(): ?string
    {
        return $this->TypeEvent;
    }

    /**
     * @param string|null $TypeEvent
     * @return FitreRecherche
     */
    public function setTypeEvent(string $TypeEvent): FitreRecherche
    {
        $this->TypeEvent = $TypeEvent;
        return $this;

    }

    /**
     * @return int|null
     */
    public function getPrixMax(): ?int
    {
        return $this->PrixMax;
    }

    /**
     * @param int|null $PrixMax
     * @return FitreRecherche
     */
    public function setPrixMax(int $PrixMax): FitreRecherche
    {
        $this->PrixMax = $PrixMax;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    /**
     * @param string|null $lieu
     * @return FitreRecherche
     */
    public function setLieu(string $lieu): FitreRecherche
    {
        $this->lieu = $lieu;
        return $this;
    }
}