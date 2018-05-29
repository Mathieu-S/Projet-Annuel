<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="images")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity="BedRoom", inversedBy="images")
     * @ORM\JoinColumn(name="bedroom_id", referencedColumnName="id")
     */
    private $bedRoom;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uri
     *
     * @param string $uri
     *
     * @return Image
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param mixed $hotel
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;
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
    }

    /**
     * Transform to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}

