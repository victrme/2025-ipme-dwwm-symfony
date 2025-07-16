<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TextRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TextExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			new TwigFilter('short_desc', [TextRuntime::class, 'shortDesc']),
		];
	}

	// public function getFunctions(): array
	// {
	// 	return [
	// 		new TwigFunction('function_name', [TextRuntime::class, 'doSomething']),
	// 	];
	// }
}
