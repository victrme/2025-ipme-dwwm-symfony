<?php

namespace App\Controller;

use App\Entity\UserOwnGame;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class PostUserOwnGameController extends AbstractController
{
	public function __construct()
	{
	}

	public function __invoke(
		SerializerInterface $serializer,
		GameRepository $gameRepository,
		EntityManagerInterface $em,
		Request $request,
	) {
		$game = $gameRepository->findOneBy(['id' => $request->get('id')]);
		$user = $this->getUser();

		if (null === $game) {
			return new Response('', Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$owngame = (new UserOwnGame())
			->setGame($game)
			->setUser($user)
			->setGameTime(0)
			->setIsInstalled(false)
			->setLastUsedAt(new \DateTimeImmutable())
			->setCreatedAt(new \DateTimeImmutable())
		;

		$em->persist($owngame);
		$em->flush();

		return new Response($serializer->serialize($owngame, 'json'));
	}
}
