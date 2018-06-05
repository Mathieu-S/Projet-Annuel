<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelierRepository")
 */
class Hotelier extends User
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $siren;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $enableAccount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hotel", mappedBy="owner")
     */
    private $hotelsOwn;

    /**
     * Hotelier constructor.
     * @param $hotels
     */
    public function __construct()
    {
        $this->hotelsOwn = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * @param mixed $siren
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;
    }

    /**
     * @return mixed
     */
    public function getEnableAccount()
    {
        return $this->enableAccount;
    }

    /**
     * @param mixed $enableAccount
     */
    public function setEnableAccount($enableAccount): void
    {
        $this->enableAccount = $enableAccount;
    }

    /**
     * @return mixed
     */
    public function getHotelsOwn()
    {
        return $this->hotelsOwn;
    }

    /**
     * @param mixed $hotelsOwn
     */
    public function setHotelsOwn($hotelsOwn): void
    {
        $this->hotelsOwn = $hotelsOwn;
    }
}
