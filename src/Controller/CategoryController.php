<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
	#[Route('/category/{slug}', name: 'app_category')]
	public function index(string $slug, GameRepository $gameRepository): Response
	{
		$games = $gameRepository->findAllByCategory($slug);

		return $this->render('category/index.twig', [
			"name" => $slug,
			"games" => $games
		]);
	}

	#[Route('admin/category/new', name: 'app_new_category')]
	public function new(Request $request, EntityManagerInterface $em): Response
	{
		/** @var Category */
		$category = new Category();
		$form = $this->createForm(CategoryType::class, $category);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$category->setImage("https://imageplaceholder.net/16x16");

			$em->persist($category);
			$em->flush();

			return $this->redirectToRoute("app_category", [
				"slug" => $category->getSlug()
			]);
		}

		return $this->render('category/new.twig', [
			"form" => $form->createView()
		]);
	}
}
