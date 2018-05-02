<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function findCitiesFromDepartment($departmentId)
    {
        return $this->createQueryBuilder('city')
            ->addSelect('department, region')
            ->join('city.department', 'department')
            ->join('department.region', 'region')
            ->where("department.id = :departmentId")
            ->orderBy('city.name', 'ASC')
            ->setParameter('departmentId', $departmentId)
            ;
    }

    public function findCitiesFromAquitaine()
    {
        return $this->createQueryBuilder('city')
            ->addSelect('department, region')
            ->join('city.department', 'department')
            ->join('department.region', 'region')
            ->where("region.slug = 'nouvelle-aquitaine'")
            ->orderBy('city.name', 'ASC')
            ;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
