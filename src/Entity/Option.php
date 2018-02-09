<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OptionRepository")
 */
class Option
{

    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Many Options concern Many BedRooms.
     * @ORM\ManyToMany(targetEntity="BedRoom", mappedBy="options")
     */
    private $bedRooms;

    public function __construct() {

        $this->bedRooms = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Option
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
     * @return mixed
     */
    public function getBedRooms()
    {
        return $this->bedRooms;
    }

    /**
     * @param mixed $bedRooms
     */
    public function setBedRooms($bedRooms)
    {
        $this->bedRooms = $bedRooms;
        return $this;
    }
}
