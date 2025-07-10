<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
	#[Route('/jeux/{slug}', name: 'app_show_game')]
	public function show(
		string $slug,
		GameRepository $gameRepository,
		ReviewRepository $reviewRepository
	): Response {
		/** @var Game */
		$game = $gameRepository->findOneBy(["slug" => $slug]);
		$categories = $game->getCategories()->getValues();
		$countries = $game->getCountries()->getValues();
		$lastReviews = $reviewRepository->findByLastComments(20);

		if (!isset($game)) {
			$this->addFlash("danger", "Ce jeu n'existe pas !");
			return $this->redirectToRoute('app_home');
		}

		return $this->render('game/show.twig', [
			"lastReviews" => $lastReviews,
			"categories" => $categories,
			"countries" => $countries,
			"game" => $game
		]);
	}
}
