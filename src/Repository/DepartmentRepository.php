<?php

namespace App\Repository;

use App\Entity\Department;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function findDepartmentsFromRegion($regionId)
    {
        $qb = $this->createQueryBuilder('d')
            ->addSelect('region')
            ->join('d.region', 'region')
            ->where("d.region = :regionId")
            ->orderBy('d.name', 'ASC')
            ->setParameter('regionId', $regionId)
            ;
        return $qb->getQuery()->getResult();
    }

    public function findDepartmentsByRegionResult(Region $region)
    {

            $regionId = $region->getId();
            $qry = <<<QUERY
SELECT d.id, d.name, d.slug, d.region_id
FROM department as d
LEFT JOIN region ON d.region_id = region.id
WHERE d.region_id = '$regionId'
GROUP BY d.id
ORDER BY d.name
QUERY;

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("id", "id");
        $rsm->addScalarResult("name", "name");
        $rsm->addScalarResult("slug", "slug");

        $query = $this->getEntityManager()->createNativeQuery($qry, $rsm);

        return $query->getResult();
    }

    public function findDepartmentsByRegion(Region $region)
    {

        $departments = $this->findDepartmentsByRegionResult($region);

        $choices = [];

        foreach ($departments as $department) {
            $choices[$department["name"]] = $department["id"];
        }
        return $choices;
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
