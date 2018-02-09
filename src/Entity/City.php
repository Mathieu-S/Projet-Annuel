<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    use IdTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    /**
     * @var float
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;
    /**
     * @var string
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;
    /**
     * @var Department
     * @ORM\ManyToOne(targetEntity=Department::class, fetch="EAGER")
     */
    private $department;
    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity=PostalCode::class, mappedBy="city", cascade="all")
     */
    private $postalCodes;
    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->postalCodes = new ArrayCollection();
    }
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
     * Set name
     *
     * @param string $name
     *
     * @return City
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
     * Set slug
     *
     * @param string $slug
     *
     * @return City
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return City
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }
    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return City
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
    /**
     * Set postalCode
     *
     * @param Collection $postalCodes
     *
     * @return City
     */
    public function setPostalCodes(Collection $postalCodes)
    {
        $this->postalCodes = $postalCodes;
        return $this;
    }
    /**
     * Get postalCode
     *
     * @return Collection
     */
    public function getPostalCodes()
    {
        return $this->postalCodes;
    }
    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }
    /**
     * @param null|Department $department
     * @return City
     */
    public function setDepartment(Department $department= null)
    {
        $this->department = $department;
        return $this;
    }

}
