<?php

namespace App\Repository;

use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function findDepartmentsFromRegion($regionId)
    {
        return $this->createQueryBuilder('d')
            ->addSelect('region')
            ->join('d.region', 'region')
            ->where("region.id = :regionId")
            ->orderBy('d.name', 'ASC')
            ->setParameter('regionId', $regionId)
            ;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('d')
            ->where('d.something = :value')->setParameter('value', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
