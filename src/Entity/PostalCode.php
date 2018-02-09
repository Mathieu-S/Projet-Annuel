<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostalCodeRepository")
 */
class PostalCode
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=5)
     */
    private $code;
    /**
     * @var PostalCode
     *
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="postalCodes", fetch="EAGER")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;
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
     * Set code
     *
     * @param string $code
     *
     * @return PostalCode
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
     * @return PostalCode
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * @param City $city
     * @return PostalCode
     */
    public function setCity(City $city)
    {
        $this->city = $city;
        return $this;
    }

}
