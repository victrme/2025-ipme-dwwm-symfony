<?php

namespace App\Controller\admin;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AdminGameController extends AbstractController
{
	#[Route('/admin/game/list', name: 'app_admin_list_game')]
	public function index(GameRepository $gameRepository): Response
	{
		return $this->render('admin_game/index.twig', [
			'games' => $gameRepository->findAll(),
		]);
	}

	#[Route('/admin/game/new', name: 'app_admin_new_game')]
	public function new(
		Request $request,
		SluggerInterface $slugger,
		EntityManagerInterface $entityManager,
	): Response {
		$game = new Game();
		$form = $this->createForm(GameType::class, $game);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$slug = $slugger->slug($game->getName());
			$game->setSlug($slug);

			$entityManager->persist($game);
			$entityManager->flush();

			return $this->redirectToRoute('app_admin_list_game');
		}

		return $this->render('admin_game/new.twig', [
			'form' => $form,
		]);
	}

	#[Route('/admin/game/update/{id}', name: 'app_admin_update_game')]
	public function update(
		string $id,
		Request $request,
		GameRepository $gameRepository,
		EntityManagerInterface $entityManager): Response
	{
		/** @var Game game */
		$game = $gameRepository->find($id);
		$form = $this->createForm(GameType::class, $game);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager->persist($game);
			$entityManager->flush();

			return $this->redirectToRoute('app_admin_show_game', [
				'id' => $game->getId(),
			]);
		}

		return $this->render('admin_game/update.twig', ['form' => $form]);
	}

	#[Route('/admin/game/delete/{id}', name: 'app_admin_delete_game')]
	public function delete(string $id): Response
	{
		return $this->render('admin_game/index.twig');
	}

	#[Route('/admin/game/show/{id}', name: 'app_admin_show_game')]
	public function show(string $id, GameRepository $gameRepository): Response
	{
		return $this->render('admin_game/show.twig', [
			'game' => $gameRepository->find($id),
		]);
	}
}
