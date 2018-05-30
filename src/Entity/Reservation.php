<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    use IdTrait;

    /**
     * @ORM\Column(name="start_date", type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(name="final_date", type="date")
     */
    private $finalDate;

    /**
     * @ORM\ManyToOne(targetEntity="BedRoom", inversedBy="reservations")
     * @JoinColumn(name="bedroom_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $bedRoom;

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getFinalDate()
    {
        return $this->finalDate;
    }

    /**
     * @param mixed $finalDate
     */
    public function setFinalDate($finalDate): void
    {
        $this->finalDate = $finalDate;
    }

    /**
     * @return mixed
     */
    public function getBedRoom()
    {
        return $this->bedRoom;
    }

    /**
     * @param mixed $bedRoom
     */
    public function setBedRoom($bedRoom): void
    {
        $this->bedRoom = $bedRoom;
    }

}
