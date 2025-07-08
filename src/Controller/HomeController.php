<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')]
    public function index(CountryRepository $countryRepository): Response
    {
        /** @var Country[] $countries */
        // SELECT * FROM country;
        $countries = $countryRepository->findAll();
        foreach ($countries as $country) {
            foreach ($country->getPublishers() as $publisher) {
                // SELECT * FROM publisher WHERE publisher.country_id = $country->getId();
                dump($country->getName(), $publisher->getName());
            }
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => 'Super message de bienvenue !',
        ]);
    }
}
