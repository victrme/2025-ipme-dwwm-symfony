<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class TextRuntime implements RuntimeExtensionInterface
{
	public function __construct()
	{
	}

	public function shortDesc(string $desc)
	{
		return substr($desc, 0, 50).'...';
	}
}
