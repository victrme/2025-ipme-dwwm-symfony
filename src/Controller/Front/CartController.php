<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Service\SessionCartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{

    #[Route('/panier', name: 'app_cart')]
    public function addGameCart(SessionCartService $sessionCartService): Response
    {
        $cartDTO = $sessionCartService->getCart();
        return $this->render('front/cart/index.html.twig', [
            'cart' => $cartDTO,
        ]);
    }

}
