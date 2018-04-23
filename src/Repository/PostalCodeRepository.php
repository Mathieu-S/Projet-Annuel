<?php

namespace App\Repository;

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

    public function createDefaultQueryBuilder()
    {
        return $this->createQueryBuilder('postalCode')
            ->select('city, department, region')
            ->join('postalCode.city', 'city')
            ->join('city.department', 'department')
            ->join('department.region', 'region')
            ->where('region.slug = nouvelle-aquitaine')
            ;
    }

//    public function findPostalCodesFromAquitaine()
//    {
//        $qb = $this->createDefaultQueryBuilder();
//        $qb->orderBy('postalCode.code');
//        return $qb->getQuery()->getResult();
//    }

    public function findPostalCodesFromAquitaine()
    {
        $qry = <<<QUERY
SELECT pc.id, pc.code
FROM postal_code as pc
LEFT JOIN city ON pc.city_id = city.id
LEFT JOIN department ON city.department_id = department.id
LEFT JOIN region ON department.region_id = region.id
WHERE region.slug = 'nouvelle-aquitaine'
GROUP BY pc.id
ORDER BY pc.code
QUERY;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult("id", "id");
        $rsm->addScalarResult("code", "code");
        $query = $this->getEntityManager()->createNativeQuery($qry, $rsm);
        return $query->getResult();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
