<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
	#[Route(name: 'app_home')]
	public function index(
		GameRepository $gameRepository,
		ReviewRepository $reviewRepository,
		CategoryRepository $categoryRepository,
	): Response {
		$allGames = $gameRepository->findBy([], ['name' => 'ASC'], 9);
		$bestSellers = $gameRepository->findByBestSellers(12);
		$lastReviews = $reviewRepository->findLast(4);
		$latestGames = $gameRepository->findBy([], ['publishedAt' => 'DESC'], 9);
		$mostExpensiveGames = $gameRepository->findBy([], ['price' => 'DESC'], 9);
		$mostPlayedCategories = $categoryRepository->findByMostPlayed();

		return $this->render('home/index.twig', [
			'allGames' => $allGames,
			'bestSellers' => $bestSellers,
			'latestGames' => $latestGames,
			'lastReviews' => $lastReviews,
			'mostExpensiveGames' => $mostExpensiveGames,
			'mostPlayedCategories' => $mostPlayedCategories,
		]);
	}
}
