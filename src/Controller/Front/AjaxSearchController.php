<?php

declare(strict_types=1);

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjaxSearchController extends AbstractController
{

    #[Route('/ajax-search')]
    public function index(): JsonResponse
    {
        $html = $this->renderView('', []);
        return new JsonResponse([
            'html' => $html,
        ], Response::HTTP_OK);
    }

}
