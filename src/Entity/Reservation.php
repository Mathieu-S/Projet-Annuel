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
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reservations")
     * @JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getcreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setcreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

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
    public function setBedRoom($bedRoom)
    {
        $this->bedRoom = $bedRoom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

}
