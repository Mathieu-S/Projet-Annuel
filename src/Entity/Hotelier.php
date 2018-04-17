<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelierRepository")
 */
class Hotelier extends User
{
    /**
     * @ORM\Column(type="string")
     */
    private $siren;

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
}
