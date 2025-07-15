<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CountryController extends AbstractController
{
	#[Route('/country/{slug}', name: 'app_show_country')]
	public function show(string $slug, GameRepository $gameRepository): Response
	{
		return $this->render('country/show.twig', [
			'name' => $slug,
			'games' => $gameRepository->findAllByCountry($slug),
		]);
	}
}
