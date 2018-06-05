<?php

namespace App\Repository;

use App\Entity\Hotelier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hotelier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotelier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotelier[]    findAll()
 * @method Hotelier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelierRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hotelier::class);
    }

//    /**
//     * @return Hotelier[] Returns an array of Hotelier objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotelier
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
