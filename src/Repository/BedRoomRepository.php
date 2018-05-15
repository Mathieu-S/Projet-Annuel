<?php

namespace App\Repository;

use App\Entity\BedRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BedRoomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BedRoom::class);
    }

    public function findAvailableBedRoom()
    {
        return $this->createQueryBuilder('bd')
            ->where('bd.availability = 1')
            ->orderBy('bd.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
