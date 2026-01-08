<?php

namespace App\Service;

use App\Entity\Game;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionCartService
{

    const CART_GAMES = 'cart_games';

    public function __construct(
        private readonly RequestStack $requestStack,
    )
    { }

    private function getSession(): SessionInterface {
        return $this->requestStack->getSession();
    }

    public function addItemToCart(string $id): void
    {
        $session = $this->getSession();
        $existingGames = [];

        if ($session->has(self::CART_GAMES)) {
            $existingGames = $session->get(self::CART_GAMES);
        }

        if (!in_array($id, $existingGames)) {
            $existingGames[] = $id;
        }

        $session->set(self::CART_GAMES, $existingGames);
    }

    public function getCart(): array
    {
        return [];
    }

    public function clearCart(): void
    {
        $this->getSession()->remove(self::CART_GAMES);
    }

}
