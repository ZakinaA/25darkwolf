<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PlanningController extends AbstractController
{
    #[Route('/planning/global', name: 'app_planning_global', methods: ['GET'])]
    // CORRECTION : Le rôle le plus bas qui doit y accéder est ROLE_PROF
    // ROLE_GESTIONNAIRE et ROLE_ADMIN sont autorisés par la HIÉRARCHIE (security.yaml)
    #[IsGranted('ROLE_PROF')] 
    public function globalPlanning(CoursRepository $coursRepository): Response
    {
        // ...
        $allCourses = $coursRepository->findAllOrderedByTime();

        return $this->render('planning/global.html.twig', [
            'allCourses' => $allCourses,
        ]);
    }
}