<?php

namespace App\Entity;

use App\Entity\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Region")
     * @JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="Department")
     * @JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotelier", inversedBy="hotelsOwn")
     * @JoinColumn(name="hotelier_id", referencedColumnName="id")
     */
    private $owner;

//    /**
//     * @ORM\OneToOne(targetEntity="Image", mappedBy="hotel", cascade={"persist"})
//     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
//     */
//    private $image;
    /**
     * @ORM\ManyToMany(targetEntity="Image", cascade={"persist"})
     */
    private $images;

    public function __construct() {

        $this->bedRooms = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->images = new ArrayCollection();
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
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $added
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     */
    public function setDepartment(Department $department)
    {
        $this->department = $department;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity(City $city)
    {
        $this->city = $city;
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
     */
    public function setPostalCode(PostalCode $postalCode)
    {
        $this->postalCode = $postalCode;
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

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getImages() {
        return $this->images;
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
