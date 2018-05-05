<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Department;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function findCitiesByDepartmentResult(Department $department)
    {

        $departmentId = $department->getId();
        $qry = <<<QUERY
SELECT c.id, c.name, c.slug, c.department_id
FROM city as c
LEFT JOIN department ON c.department_id = department.id
WHERE c.department_id = '$departmentId'
GROUP BY c.id
ORDER BY c.name
QUERY;

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("id", "id");
        $rsm->addScalarResult("name", "name");
        $rsm->addScalarResult("slug", "slug");

        $query = $this->getEntityManager()->createNativeQuery($qry, $rsm);

        return $query->getResult();
    }

    public function findCitiesByDepartment(Department $department)
    {

        $cities = $this->findCitiesByDepartmentResult($department);

        $choices = [];

        foreach ($cities as $city) {
            $choices[$city["name"]] = $city["id"];
        }
        return $choices;
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

}
