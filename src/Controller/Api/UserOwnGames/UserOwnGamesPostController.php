<?php

declare(strict_types=1);

namespace App\Controller\Api\UserOwnGames;

use App\Entity\User;
use App\Entity\UserOwnGame;
use App\Repository\GameRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class UserOwnGamesPostController extends AbstractController
{

    public function __invoke(
        string                 $gameId,
        GameRepository         $gameRepository,
        EntityManagerInterface $em,
        SerializerInterface    $serializer,
    ): Response
    {
        if (null === $game = $gameRepository->findOneBy(['id' => $gameId])) {
            return new Response('C\'est quoi ce jeu ?', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var User $user */
        $user = $this->getUser();
        $userOwnGame = (new UserOwnGame())
            ->setUser($user)
            ->setGame($game)
            ->setCreatedAt(new DateTimeImmutable());

        $em->persist($userOwnGame);
        $em->flush();

        return new Response(
            $serializer->serialize(
                $userOwnGame,
                'json',
                ['groups' => 'userOwnGame:item']
            ), Response::HTTP_CREATED
        );
    }
}
