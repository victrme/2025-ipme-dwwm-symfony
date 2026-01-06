<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/game', name: 'app_admin_game')]
class GameController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface    $translator,
        private Logger                 $logger,
    )
    {
    }

    #[Route('', name: '')]
    public function index(
        GameRepository     $gameRepository,
        PaginatorInterface $paginator,
        Request            $request
    ): Response
    {
        $pagination = $paginator->paginate(
            $gameRepository->getAll(),
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );
        $pagination->setCustomParameters([
            'align' => 'center',
        ]);

        return $this->render('admin/show-game.html.twig', [
            'games' => $pagination
        ]);
    }

    #[Route('/new', '_new')]
    public function new(Request $request): Response
    {
        return $this->handleForm($request, new Game());
    }

    #[Route('/edit/{id}', '_edit')]
    public function edit(Request $request, Game $game): Response
    {
        return $this->handleForm($request, $game);
    }

    private function handleForm(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = 'success';
            try {
                $this->em->persist($game);
                $this->em->flush();
            } catch (\Throwable $exception) {
                $type = 'danger';
                $this->logger->error($exception->getMessage());
            }
            $this->addFlash($type, $this->translator->trans('alert.game.new.' . $type, [], 'admin'));
            return $this->redirectToRoute('app_admin_game');
        }

        return $this->render('/admin/game/form.html.twig', [
            'form' => $form,
            'mode' => $game->getId() == null ? 'new' : 'edit',
            'game' => $game,
        ]);
    }
}
