<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<>
 */
abstract class SearchedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entity)
    {
        parent::__construct($registry, $entity);
    }

    protected function getArraySearch(string $search): array {
        $possibilities[] = $search;
        $possibilities[] = $search . '%';
        $possibilities[] = '%' . $search;
        $possibilities[] = '%' . $search . '%';
        $possibilities[] = '%' . str_replace(' ', '%', $search) . '%';
        return $possibilities;
    }

    public function findBySearch(string $searchedValue): array
    {
        $searchedValues = $this->getArraySearch($searchedValue);
        $qb = $this->createQueryBuilder('s')
            ->select('s.name', 's.slug');

        $addSelect = '(CASE ';
        foreach ($searchedValues as $key => $searched) {
            $qb->orWhere('s.name LIKE :searched' . $key)
                ->setParameter('searched'.$key, $searched);

            $addSelect .= 'WHEN s.name LIKE :searched'.$key.' THEN ' . (5 - $key) . ' ';
        }

        $addSelect .= 'ELSE 0 ';
        $addSelect .= 'END) AS HIDDEN relevance_score';

        $qb->addSelect($addSelect);

        $qb->orderBy('relevance_score', 'DESC')
            ->addOrderBy('s.name', 'ASC')
            ->setMaxResults(3);

        return $qb->getQuery()->getArrayResult();
    }

}
