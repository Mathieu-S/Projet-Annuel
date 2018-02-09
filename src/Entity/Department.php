<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartmentRepository")
 */
class Department
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
     * @var string
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;
    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity=Region::class)
     * @ORM\JoinColumn(name="region_id", nullable=true)
     */
    private $region;
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
     * @return Department
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
     * @return Department
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
     * Set code
     *
     * @param string $code
     *
     * @return Department
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }
    /**
     * @param Region $region
     * @return Department
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
        return $this;
    }

}
