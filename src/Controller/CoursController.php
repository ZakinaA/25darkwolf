<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    #[Route(name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();

        // 1. Redirection automatique si c'est un ÉLÈVE
        if ($this->isGranted('ROLE_ELEVE') || ($user && $user->getEleve())) {
            return $this->redirectToRoute('app_eleve_mes_cours');
        }

        // 2. Redirection automatique si c'est un PROFESSEUR
        if ($this->isGranted('ROLE_PROF') || ($user && $user->getProfesseur())) {
             return $this->redirectToRoute('app_professeur_mes_cours');
        }

        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    // --- ROUTES SPÉCIFIQUES ---

    #[Route('/mes-cours', name: 'app_eleve_mes_cours', methods: ['GET'])]
    #[IsGranted('ROLE_ELEVE')]
    public function mesCours(CoursRepository $coursRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $eleve = $user->getEleve();

        if (!$eleve) {
            $this->addFlash('danger', 'Votre compte utilisateur n\'est pas relié à une fiche élève.');
            return $this->redirectToRoute('app_home');
        }

        $mesCours = $coursRepository->findCoursByEleve($eleve->getId());

        // CHANGEMENT ICI : on pointe vers le nouveau fichier _eleve
        return $this->render('cours/mes_cours_eleve.html.twig', [
            'cours' => $mesCours,
            'eleve' => $eleve
        ]);
    }

    #[Route('/espace-professeur', name: 'app_professeur_mes_cours', methods: ['GET'])]
    #[IsGranted('ROLE_PROF')]
    public function mesCoursProfesseur(CoursRepository $coursRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $professeur = $user->getProfesseur();

        if (!$professeur) {
            $this->addFlash('danger', 'Votre compte utilisateur n\'est pas lié à un profil Professeur.');
            return $this->redirectToRoute('app_home');
        }

        $mesCours = $coursRepository->findCoursByProfesseur($professeur->getId());

        return $this->render('cours/mes_cours_professeur.html.twig', [
            'cours' => $mesCours,
            'professeur' => $professeur
        ]);
    }

    // --- ROUTES DYNAMIQUES ---

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}