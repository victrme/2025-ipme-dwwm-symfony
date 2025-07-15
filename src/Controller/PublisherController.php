<?php

namespace App\Controller;

use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PublisherController extends AbstractController
{
	#[Route('/publisher', name: 'app_publisher')]
	public function index(PublisherRepository $publisherRepository): Response
	{
		$publishers = $publisherRepository->findAll();

		return $this->render('publisher/index.twig', [
			'publishers' => $publishers,
		]);
	}

	#[Route('admin/new/publisher', name: 'app_new_publisher')]
	public function new(Request $request, EntityManagerInterface $em): Response
	{
		/** @var Publisher */
		$publisher = new Publisher();
		$form = $this->createForm(PublisherType::class, $publisher);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$publisher->setCreatedAt(new \DateTimeImmutable());
			$publisher->setSlug(strtolower($publisher->getName()));

			$em->persist($publisher);
			$em->flush();

			return $this->redirectToRoute('app_publisher');
		}

		return $this->render('publisher/new.twig', [
			'form' => $form->createView(),
		]);
	}
}
