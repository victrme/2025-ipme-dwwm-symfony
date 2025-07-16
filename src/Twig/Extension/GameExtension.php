<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\GameRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class GameExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			new TwigFilter('average_rating', [GameRuntime::class, 'getRatingAvg']),
		];
	}
}
