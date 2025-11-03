<?php
// src/Controller/DashboardController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            // Si pas connecté, on redirige vers la page visiteur ou login
            return $this->redirectToRoute('app_login'); 
        }

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }
}
