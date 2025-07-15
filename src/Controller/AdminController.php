<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AdminController extends AbstractController
{
	#[IsGranted("ROLE_ADMIN")]
	#[Route('/admin', name: 'app_admin')]
	public function index(): Response
	{
		return $this->render('admin/index.twig');
	}
}
