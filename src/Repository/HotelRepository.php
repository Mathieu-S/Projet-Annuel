<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HotelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function getOwnerHotels($idOwners)
    {
        return $this->createQueryBuilder('h')
            ->where('h.owner = :value')->setParameter('value', $idOwners)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('h')
            ->where('h.something = :value')->setParameter('value', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
