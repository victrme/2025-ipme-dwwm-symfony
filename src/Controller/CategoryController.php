<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
	#[Route('/category/{slug}', name: 'app_category')]
	public function index(string $slug, GameRepository $gameRepository): Response
	{
		$games = $gameRepository->findAllByCategory($slug);

		return $this->render('category/index.twig', [
			"name" => $slug,
			"games" => $games
		]);
	}
}
