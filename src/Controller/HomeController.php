<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    /**
     * C'est cette ligne qui crée la route 'app_home'
     */
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        // 1. Récupérer la liste des cours triés en utilisant la méthode du repository.
        // Cela suppose que la méthode findAllSortedByDayAndTime() existe dans votre CoursRepository.
        $planningCours = $coursRepository->findAllSortedByDayAndTime();

        // 2. Ceci est votre page d'accueil publique
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'planning_cours' => $planningCours, // Transmission des données pour l'affichage du planning
        ]);
    }
}