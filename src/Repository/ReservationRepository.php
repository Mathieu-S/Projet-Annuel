<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function getOwnerReservations($idOwner)
    {
        return $this->createQueryBuilder('r')
            ->join('r.bedRoom', 'bedroom')
            ->join('bedroom.hotel', 'hotel')
            ->where('hotel.owner = :value')->setParameter('value', $idOwner)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

}
