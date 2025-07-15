<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
	#[Route('/user/{id}', name: 'app_show_user')]
	public function show(
		string $id,
		UserRepository $userRepository,
		ReviewRepository $reviewRepository,
	): Response {
		/** @var User */
		$user = $userRepository->findOneBy(['id' => $id]);
		$reviews = $reviewRepository->findLatestByUserId($user->getId());

		return $this->render('user/show.twig', [
			'user' => $user,
			'reviews' => $reviews,
		]);
	}
}
