<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('/admin/game', name: 'app_admin_game')]
    public function index(GameRepository $gameRepository, EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $gameRepository->getAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );
        $pagination->setCustomParameters([
            'align' => 'center',
        ]);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminGameController',
            'games' => $pagination
        ]);
    }
}
