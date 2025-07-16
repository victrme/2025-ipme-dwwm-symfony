<?php

namespace App\Twig\Runtime;

use App\Entity\Game;
use App\Entity\Review;
use App\Repository\GameRepository;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class GameRuntime implements RuntimeExtensionInterface
{
	public function __construct(
		private GameRepository $gameRepository,
		private Environment $twig,
	) {
	}

	public function getRatingAvg(Game $game): string
	{
		// Calculate & sanitize average review

		/** @var Review[] */
		$reviews = $game->getReviews();
		$average = 0;

		foreach ($reviews as $review) {
			$average += $review->getRating();
		}

		$average = $average / count($reviews);

		// Get stars SVGs, render html

		$html = '';

		for ($i = 0; $i < 5; ++$i) {
			if ($average > $i) {
				$html .= $this->twig->render('partial/icons/_fullstar.twig');
			} elseif ($average + 1 < $i) {
				$html .= $this->twig->render('partial/icons/_emptystar.twig');
			} else {
				$html .= $this->twig->render('partial/icons/_halfstar.twig');
			}
		}

		return $html;
	}

	public function getLastGame(): ?Game
	{
		return $this->gameRepository->findOneBy([], ['publishedAt' => 'DESC']);
	}
}
