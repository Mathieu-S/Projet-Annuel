<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 */
class Hotel
{
    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="PostalCode")
     * @JoinColumn(name="postal_code_id", referencedColumnName="id")
     */
    private $postalCode;

    /**
     * @ORM\OneToMany(targetEntity="BedRoom", mappedBy="hotel")
     */
    private $bedRooms;

    /**
     * Many Hotels have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="hotels")
     */
    private $users;

    public function __construct() {

        $this->bedRooms = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return Hotel
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    /**
     * @param PostalCode $postalCode
     * @return Hotel
     */
    public function setPostalCode(PostalCode $postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBedRooms()
    {
        return $this->bedRooms;
    }

    /**
     * @return mixed
     */
    public function setBedRooms(BedRoom $bedRooms)
    {
        $this->bedRooms = $bedRooms;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }
}
