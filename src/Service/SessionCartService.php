<?php

namespace App\Service;

use App\DTO\CartDTO;
use App\DTO\GameDTO;
use App\Entity\Game;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SessionCartService
{

    const CART_GAMES = 'cart_games';

    public function __construct(
        private readonly RequestStack        $requestStack,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    /**
     * @throws ExceptionInterface
     */
    public function addItemToCart(Game $game): void
    {
        $session = $this->getSession();
        $existingGames = [];

        if ($session->has(self::CART_GAMES)) {
            $existingGames = $session->get(self::CART_GAMES);
        }

        if (!in_array($game->getId(), $existingGames)) {
            $existingGames[] =  $this->serializer->serialize(
                new GameDTO(
                    $game->getName(),
                    $game->getSlug(),
                    $game->getThumbnailCover(),
                    $game->getThumbnailCoverLink(),
                    $game->getPrice()
                ),
                'json'
            );

        }

        $session->set(self::CART_GAMES, $existingGames);
    }

    /**
     * @throws ExceptionInterface
     */
    public function getCart(): CartDTO
    {
        $totalPrice = 0;
        $games = [];
        foreach ($this->getSession()->get(self::CART_GAMES) as $jsonGame) {
            $gameDTO = $this->serializer->deserialize(
                $jsonGame,
                GameDTO::class,
                'json');
            $totalPrice += $gameDTO->getPrice();
            $games[] = $gameDTO;
        }
        return new CartDTO($totalPrice, $games);
    }

    public function clearCart(): void
    {
        $this->getSession()->remove(self::CART_GAMES);
    }

}
