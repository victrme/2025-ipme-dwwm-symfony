<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\PriceRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class PriceExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			new TwigFilter('euro', [PriceRuntime::class, 'transformEuro']),
		];
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('function_name', [PriceRuntime::class, 'doSomething']),
		];
	}
}
