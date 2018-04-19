<?php

namespace App\Entity;

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
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $enableAccount;

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
}
