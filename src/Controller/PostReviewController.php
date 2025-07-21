<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class PostReviewController extends AbstractController
{
	public function __construct()
	{
	}

	public function __invoke(
		SerializerInterface $serializer,
		GameRepository $gameRepository,
		EntityManagerInterface $em,
		Request $request,
		Review $review)
	{
		$data = json_decode($request->getContent(), true);
		$game = $gameRepository->findOneBy(['id' => $request->get('id')]);
		$user = $this->getUser();

		if (null === $game) {
			return new Response('', Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		$review = (new Review())
			->setGame($game)
			->setUser($user)
			->setDownVote(0)
			->setUpVote(0)
			->setTitle($data['title'])
			->setContent($data['content'])
			->setRating($data['rating'])
			->setCreatedAt(new \DateTimeImmutable())
		;

		$em->persist($review);
		$em->flush();

		return new Response($serializer->serialize($review, 'json'));
	}
}
