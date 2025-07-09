<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(name: 'app_home')]
    public function index(GameRepository $gameRepository, ReviewRepository $reviewRepository): Response
    {
        $allGames = $gameRepository->findBy([], ["name" => "ASC"], 9);
        $bestSellers = $gameRepository->findByBestSellers(20);
        $latestGames = $gameRepository->findBy([], ["publishedAt" => "DESC"], 9);
        $mostExpensiveGames = $gameRepository->findBy([], ["price" => "DESC"], 9);
        $lastReviews = $reviewRepository->findByLastComments(4);

        return $this->render('home/index.html.twig', [
            "allGames" => $allGames,
            "bestSellers" => $bestSellers,
            "latestGames" => $latestGames,
            "lastReviews" => $lastReviews,
            "mostExpensiveGames" =>  $mostExpensiveGames,
        ]);
    }
}
