<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/game')]
class GameController extends AbstractController
{
    #[Route('/new')]
    public function new(Request $request): Response
    {
        return $this->handleForm($request, new Game());
    }

    #[Route('/edit/{id}')]
    public function edit(Request $request, Game $game): Response
    {
        return $this->handleForm($request, $game);
    }

    private function handleForm(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($game);
        }

        return $this->render('/admin/game/new.html.twig', [
            'form' => $form,
        ]);
    }
}
