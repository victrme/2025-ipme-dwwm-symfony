<?php

namespace App\Twig\Runtime;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Twig\Extension\RuntimeExtensionInterface;

class CategoryRuntime implements RuntimeExtensionInterface
{
	public function __construct(
		private CategoryRepository $categoryRepository,
	) {
	}

	public function getCategoryNames(): mixed
	{
		/** @var Category[] $categories */
		$categories = $this->categoryRepository->findAll();
		$names = [];

		foreach ($categories as $category) {
			$names[] = $category->getName();
		}

		return $names;
	}
}
