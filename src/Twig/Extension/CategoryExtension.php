<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CategoryRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoryExtension extends AbstractExtension
{
	// public function getFilters(): array
	// {
	// }

	public function getFunctions(): array
	{
		return [
			new TwigFunction('get_category_names', [CategoryRuntime::class, 'getCategoryNames']),
		];
	}
}
