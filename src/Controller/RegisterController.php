<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
	#[Route('/inscription', name: 'app_register')]
	public function index(Request $request, EntityManagerInterface $em): Response
	{
		$user = new User();
		$form = $this->createForm(RegisterType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$user->setCreatedAt(new DateTimeImmutable());

			$em->persist($user);
			$em->flush();

			$this->redirectToRoute("app_home");
		}

		return $this->render('register/index.twig', [
			"form" => $form->createView()
		]);
	}
}
