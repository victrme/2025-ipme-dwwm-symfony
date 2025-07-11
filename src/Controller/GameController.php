<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{

    #[Route('/jeux/{slug}', name: 'app_show_game')]
    public function show(string $slug, GameRepository $gameRepository): Response
    {
        $game = $gameRepository->findOneBy(['slug' => $slug]);
        if ($game === null) {
            // Utilisable seulement dans un controller !
            $this->addFlash('danger', 'Ce jeu n\'existe pas !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('/categorie/{slug}', name: 'app_game_category')]
    public function gameCategory(
        string $slug,
        CategoryRepository $categoryRepository
    ): Response
    {
        $category = $categoryRepository->findFullBySlug($slug);
        if ($category === null) {
            $this->addFlash('danger', 'Cette catégorie n\'existe pas !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('game/games_by_category.html.twig', [
            'category' => $category,
        ]);
    }

}
