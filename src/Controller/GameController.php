<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\GameRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
	#[Route('/jeux/{slug}', name: 'app_show_game')]
	public function show(
		string $slug,
		Request $request,
		GameRepository $gameRepository,
		ReviewRepository $reviewRepository,
		EntityManagerInterface $entityManager,
	): Response {
		/** @var Game */
		$game = $gameRepository->findOneBy(['slug' => $slug]);

		if (!isset($game)) {
			$this->addFlash('danger', "Ce jeu n'existe pas !");

			return $this->redirectToRoute('app_home');
		}

		// Handle review form

		$userReview = new Review();
		$form = $this->createForm(ReviewType::class, $userReview);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$userReview->setCreatedAt(new \DateTimeImmutable());
			$userReview->setTitle('');
			$userReview->setGame($game);
			$userReview->setUser($this->getUser());
			$entityManager->persist($userReview);
			$entityManager->flush();
		}

		// Render

		$lastReviews = $reviewRepository->findLastByGameId($game->getId(), 20);
		$categories = $game->getCategories()->getValues();
		$countries = $game->getCountries()->getValues();

		return $this->render('game/show.twig', [
			'categories' => $categories,
			'countries' => $countries,
			'reviews' => $lastReviews,
			'form' => $form,
			'game' => $game,
			'loggedin' => true,
		]);
	}
}
