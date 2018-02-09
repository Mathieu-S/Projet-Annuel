<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BedRoomRepository")
 */
class BedRoom
{
    use IdTrait;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var boolean
     * @ORM\Column(name="availability", type="boolean")
     */
    private $availability;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="bedRooms")
     * @JoinColumn(name="hotel_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $hotel;

    /**
     * Many BedRooms have Many Options.
     * @ORM\ManyToMany(targetEntity="Option", inversedBy="bedRooms")
     * @ORM\JoinTable(name="bedrooms_options")
     */
    private $options;

    public function __construct() {

        $this->options = new ArrayCollection();
    }

    /**
     * Set description
     *
     * @param $description
     *
     * @return BedRoom
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return BedRoom
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
    /**
     * Get code
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param boolean $availability
     *
     * @return BedRoom
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
        return $this;
    }
    /**
     * Get code
     *
     * @return boolean
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @return BedRoom
     */
    public function getHotel()
    {
        return $this->hotel;
    }
    /**
     * @param Hotel $hotel
     * @return BedRoom
     */
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
