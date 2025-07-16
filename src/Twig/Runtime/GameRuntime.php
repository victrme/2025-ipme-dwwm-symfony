<?php

namespace App\Twig\Runtime;

use App\Entity\Game;
use App\Entity\Review;
use App\Repository\GameRepository;
use Twig\Extension\RuntimeExtensionInterface;

class GameRuntime implements RuntimeExtensionInterface
{
	public function __construct(
		private GameRepository $gameRepository,
	) {
	}

	public function getRatingAvg(Game $game): float
	{
		/** @var Review[] */
		$reviews = $game->getReviews();
		$notes = 0;

		foreach ($reviews as $review) {
			$notes += $review->getRating();
		}

		return $notes / count($reviews);
	}

	public function getLastGame(): ?Game
	{
		return $this->gameRepository->findOneBy([], ['publishedAt' => 'DESC']);
	}
}
