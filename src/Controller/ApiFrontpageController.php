<?php

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ApiFrontpageController extends AbstractController
{
    public function __construct() {}

    public function __invoke(Game $game): Game
    {
        return $game;
    }
}
