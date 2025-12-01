<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Inscription;
use App\Entity\Cours;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/eleve')]
final class EleveController extends AbstractController
{
    // =========================================================
    // 1. ROUTES SPÉCIFIQUES (DOIVENT ÊTRE EN HAUT)
    // =========================================================

    /**
     * Dashboard de l'élève connecté (N'A PAS BESOIN D'ID DANS L'URL)
     * On supprime l'ID de la route car l'élève est trouvé via $this->getUser().
     */
    #[Route('/dashboard', name: 'app_eleve_dashboard', methods: ['GET'])]
    #[IsGranted('ROLE_ELEVE')]
    public function dashboard(EleveRepository $eleveRepository): Response
    {
        $user = $this->getUser();
        $eleve = $eleveRepository->findOneBy(['user' => $user]);

        if (!$eleve) {
            // Vous pouvez rediriger l'utilisateur vers une page de création de profil si besoin
            $this->addFlash('error', 'Profil élève non trouvé. Veuillez compléter votre inscription.');
            return $this->redirectToRoute('app_home'); 
        }

        return $this->render('eleve/dashboard.html.twig', [
            'eleve' => $eleve,
        ]);
    }
    
    /**
     * Catalogue des cours disponibles pour l'élève.
     */
    #[Route('/catalogue', name: 'app_eleve_catalogue_cours', methods: ['GET'])]
    #[IsGranted('ROLE_ELEVE')]
    public function catalogue(CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAll();

        return $this->render('cours/catalogue_cours.html.twig', [
            'cours' => $cours,
        ]);
    }

    /**
     * Permet à un élève de s'inscrire ou de se désinscrire d'un cours.
     */
    #[Route('/toggle-inscription/{courseId}', name: 'app_eleve_toggle_inscription', methods: ['GET'])]
    #[IsGranted('ROLE_ELEVE')]
    public function toggleInscription(
        int $courseId, 
        EntityManagerInterface $entityManager, 
        CoursRepository $coursRepository
    ): Response
    {
        $user = $this->getUser();
        $eleve = $entityManager->getRepository(Eleve::class)->findOneBy(['user' => $user]);
        
        if (!$eleve) {
             $this->addFlash('error', 'Profil élève introuvable.');
             return $this->redirectToRoute('app_eleve_catalogue_cours');
        }

        $cours = $coursRepository->find($courseId);
        if (!$cours) {
            $this->addFlash('error', 'Cours non trouvé.');
            return $this->redirectToRoute('app_eleve_catalogue_cours');
        }

        $inscriptionRepository = $entityManager->getRepository(Inscription::class);
        $inscriptionFound = $inscriptionRepository->findOneBy([
            'eleve' => $eleve,
            'cours' => $cours,
        ]);
        

        if ($inscriptionFound) {
            // Désinscription
            $entityManager->remove($inscriptionFound);
            $this->addFlash('success', 'Votre désinscription du cours "' . $cours->getLibelle() . '" est confirmée.');
        } else {
            // Inscription
            $inscription = new Inscription();
            $inscription->setEleve($eleve);
            $inscription->setCours($cours);
            $entityManager->persist($inscription);
            $this->addFlash('success', 'Félicitations ! Vous êtes inscrit(e) au cours "' . $cours->getLibelle() . '".');
        }
        
        $entityManager->flush();
        return $this->redirectToRoute('app_eleve_catalogue_cours');
    }
    
    // =========================================================
    // 2. ROUTES GÉNÉRIQUES (CRUD)
    // =========================================================

    #[Route(name: 'app_eleve_index', methods: ['GET'])]
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eleve_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eleve);
            $entityManager->flush();

            return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleve/new.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eleve_show', methods: ['GET'])]
    public function show(Eleve $eleve): Response
    {
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eleve_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('eleve/edit.html.twig', [
            'eleve' => $eleve,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eleve_delete', methods: ['POST'])]
    public function delete(Request $request, Eleve $eleve, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($eleve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_eleve_index', [], Response::HTTP_SEE_OTHER);
    }
}