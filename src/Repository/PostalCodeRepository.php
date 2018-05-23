<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\PostalCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostalCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostalCode::class);
    }

    public function findPostalCodesFromAquitaine()
    {
        return $this->createQueryBuilder('postalCode')
            ->addSelect('city, department, region')
            ->join('postalCode.city', 'city')
            ->join('city.department', 'department')
            ->join('department.region', 'region')
            ->where("region.slug = 'nouvelle-aquitaine'")
            ->orderBy('postalCode.code', 'ASC')
            ;
    }

    public function findPostalCodesByCityResult(City $city)
    {

        $cityId = $city->getId();
        $qry = <<<QUERY
SELECT pc.id, pc.code, pc.city_id
FROM postal_code as pc
LEFT JOIN city ON pc.city_id = city.id
WHERE pc.city_id = '$cityId'
GROUP BY pc.id
ORDER BY pc.code
QUERY;

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("id", "id");
        $rsm->addScalarResult("code", "code");

        $query = $this->getEntityManager()->createNativeQuery($qry, $rsm);

        return $query->getResult();
    }

    public function findPostalCodesByCity(City $city)
    {

        $postalCodes = $this->findPostalCodesByCityResult($city);

        $choices = [];

        foreach ($postalCodes as $postalCode) {
            $choices[$postalCode["code"]] = $postalCode["id"];
        }
        return $choices;
    }

}
