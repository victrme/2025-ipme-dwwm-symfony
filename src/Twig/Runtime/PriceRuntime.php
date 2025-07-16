<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class PriceRuntime implements RuntimeExtensionInterface
{
	public function __construct()
	{
	}

	public function transformEuro(int $price)
	{
		return $price.'€';
	}
}
