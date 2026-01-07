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
    {

    }

    private function getSession(): SessionInterface {
        return $this->requestStack->getSession();
    }

    public function addItemToCart(Game $game): void
    {
        // TODO : some logic there
    }

    public function getCart(): array
    {
        return [];
    }

}
