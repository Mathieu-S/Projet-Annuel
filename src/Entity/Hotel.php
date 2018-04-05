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
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * Set name
     *
     * @param string $name
     *
     * @return Hotel
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Hotel
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Hotel
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
