<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\GameRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GameExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			// new TwigFilter('average_rating', [GameRuntime::class, 'getRatingAvg']),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_rating_avg', [GameRuntime::class, 'getRatingAvg']),
			new TwigFunction('get_last_game', [GameRuntime::class, 'getLastGame']),
		];
	}
}
