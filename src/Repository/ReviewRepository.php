<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Review::class);
	}

	/**
	 * @param ?int $id
	 * @param ?int $limit
	 * @return Review[]
	 */
	public function findLatestByUserId($id, $limit = 10)
	{
		return $this->createQueryBuilder("r")
			->join("r.user", "u")
			->where("u.id = :id")
			->setParameter("id", $id)
			->setMaxResults($limit)
			->getQuery()
			->getResult();
	}

	/**
	 * @param ?int $limit
	 * @return Review[]
	 */
	public function findByLastComments($limit = 10)
	{
		return $this->createQueryBuilder("r")
			->orderBy("r.createdAt", 'DESC')
			->setMaxResults($limit)
			->getQuery()
			->getResult();
	}

	/** @return Review[] */
	public function findByLastMostRatedComments()
	{
		return $this->createQueryBuilder("r")
			->orderBy("r.createdAt", 'DESC')
			->addOrderBy("r.rating", "DESC")
			->getQuery()
			->getResult();
	}
}
