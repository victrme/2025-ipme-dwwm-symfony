<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Category::class);
	}

	/**
	 * @param int|null $limit
	 * @return Category[]
	 */
	public function findByMostPlayed($limit = null)
	{
		$qb = $this->createQueryBuilder("c")
			->join("c.games", "g")
			->join("g.ownedByUser", "uog")
			->groupBy("c.id")
			->orderBy("SUM(uog.gameTime)", "DESC");

		if (isset($limit)) {
			$qb->setMaxResults($limit);
		}

		return $qb->getQuery()->getResult();
	}

	//    /**
	//     * @return Category[] Returns an array of Category objects
	//     */
	//    public function findByExampleField($value): array
	//    {
	//        return $this->createQueryBuilder('c')
	//            ->andWhere('c.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->orderBy('c.id', 'ASC')
	//            ->setMaxResults(10)
	//            ->getQuery()
	//            ->getResult()
	//        ;
	//    }

	//    public function findOneBySomeField($value): ?Category
	//    {
	//        return $this->createQueryBuilder('c')
	//            ->andWhere('c.exampleField = :val')
	//            ->setParameter('val', $value)
	//            ->getQuery()
	//            ->getOneOrNullResult()
	//        ;
	//    }
}
