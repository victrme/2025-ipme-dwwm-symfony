<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    #[Route(name: 'app_home')]
    public function index(
        CountryRepository   $countryRepository,
        GameRepository      $gameRepository
    ): Response
    {
        /** @var Country $country */
        // SELECT * FROM country WHERE code = 'fr';
        $country = $countryRepository->findOneBy(
            ['code' => 'fr']
        );

        if (null !== $country) {
            $games = $gameRepository->findBy(
                [],
                ['name' => 'ASC', 'publishedAt' => 'DESC']
            );
            dump($games);
        }
//        $games =
//        foreach ($countries as $country) {
//            foreach ($country->getGames() as $game) {
//                dump($country->getName(), $game->getName());
//            }
//        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => 'Super message de bienvenue !',
        ]);
    }

}
