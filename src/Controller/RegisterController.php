<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        // RegisterType::class => App\Form\RegisterType
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request); // Lie la requête HTTP en POST (à la soumission du form) à notre objet form

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new DateTimeImmutable());
            $em->persist($user); // Indiquer que l'instance $user de la classe User, doit être "INSERT" en base de données
            $em->flush(); // Envoyer / confirmer que la requête d'INSERT doit passer en base de données

            $this->addFlash('success', 'Inscription réussie !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('register/index.html.twig', [
            'formRegister' => $form,
        ]);
    }
}
