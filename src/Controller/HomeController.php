<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    /**
     * C'est cette ligne qui crée la route 'app_home'
     */
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        // Ceci est votre page d'accueil publique
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}