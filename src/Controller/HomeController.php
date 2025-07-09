<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(name: 'app_home')]
    public function index(GameRepository $gameRepository): Response
    {
        $allGames = $gameRepository->findBy([], ["name" => "ASC"], 9);
        $latestGames = $gameRepository->findBy([], ["publishedAt" => "DESC"], 9);
        $mostExpensive = $gameRepository->findBy([], ["price" => "DESC"], 9);

        return $this->render('home/index.html.twig', [
            "all" => $allGames,
            "latest" => $latestGames,
            "expensive" =>  $mostExpensive,
        ]);
    }
}
