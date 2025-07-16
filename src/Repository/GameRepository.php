<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, Game::class);
	}

	public function getAll()
	{
		$qb = $this->createQueryBuilder('g')->orderBy('g.id');

		return $qb;
	}

	/**
	 * @param string $slug
	 *
	 * @return ?Game[]
	 */
	public function findAllByCategory($slug)
	{
		$qb = $this->createQueryBuilder('g')
			->join('g.categories', 'c')
			->andWhere('c.slug = :slug')
			->setParameter('slug', $slug);

		return $qb->getQuery()->getResult();
	}

	/**
	 * @param string $slug
	 *
	 * @return ?Game[]
	 */
	public function findAllByCountry($slug)
	{
		$qb = $this->createQueryBuilder('g')
			->join('g.countries', 'c')
			->andWhere('c.slug = :slug')
			->setParameter('slug', $slug);

		return $qb->getQuery()->getResult();
	}

	/**
	 * @return Game[]
	 */
	public function findByBestSellers(int $amount)
	{
		return $this->createQueryBuilder('g')
			->join('g.ownedByUser', 'oBu')
			->groupBy('g.id')
			->orderBy('COUNT(g.name)')
			->setMaxResults($amount ?? 1)
			->getQuery()
			->getResult()
		;
	}
}
