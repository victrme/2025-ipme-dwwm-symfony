<?php

declare(strict_types=1);

namespace App\Controller\Api\Review;

use App\Entity\Review;
use App\Repository\GameRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PostReviewController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(
        Request                $request,
        GameRepository         $gameRepository,
        EntityManagerInterface $em,
        SerializerInterface    $serializer
    ): Response
    {
        $data = json_decode($request->getContent(), true);

        if (null === $game = $gameRepository->findOneBy(['id' => $request->get('id')])) {
            return new Response('Jeu incorrect', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $review = (new Review())
            ->setGame($game)
            ->setUser($this->getUser())
            ->setContent($data['content'])
            ->setRating($data['rating'])
            ->setCreatedAt(new DateTimeImmutable());

        $em->persist($review);
        $em->flush();

        return new Response($serializer->serialize(
            $review,
            'json',
            ['groups' => ['review:post', 'review:item']]
        ), Response::HTTP_CREATED);
    }
}
