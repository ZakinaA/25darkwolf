<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Inscription;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security; // si tu l’utilises


#[Route('/cours')]
final class CoursController extends AbstractController
{
    #[Route(name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();

        // 1. Redirection pour les rôles de GESTION/ADMIN/PROF vers le planning global (le plus large)
        // Note: L'Admin et le Gestionnaire peuvent voir la liste complète dans le planning
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_GESTIONNAIRE') || $this->isGranted('ROLE_PROF')) {
            // S'il est connecté avec un rôle de gestion, on le redirige vers la vue d'ensemble.
            return $this->redirectToRoute('app_planning_global');
        }

        // 2. Redirection pour les ÉLÈVES vers leur page personnelle
        // Cette condition est vérifiée UNIQUEMENT si l'utilisateur n'est pas Admin/Gest/Prof
        if ($this->isGranted('ROLE_ELEVE')) {
            // Pas de vérification d'objet Eleve ici, car elle est faite dans mesCours()
            return $this->redirectToRoute('app_eleve_mes_cours');
        }

        // 3. Vue par défaut (si anonyme ou utilisateur non reconnu)
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

        // Cette vérification est cruciale et doit rester ici pour les élèves
        if (!$eleve) {
            $this->addFlash('danger', 'Votre compte utilisateur n\'est pas relié à une fiche élève.');
            // Redirige vers la page d'accueil car l'utilisateur ne devrait pas être là
            return $this->redirectToRoute('app_home'); 
        }

        $mesCours = $coursRepository->findCoursByEleve($eleve->getId());

        return $this->render('cours/mes_cours_eleve.html.twig', [
            'cours' => $mesCours,
            'eleve' => $eleve
        ]);
    }

    #[Route('/catalogue', name: 'app_catalogue', methods: ['GET'])]
    #[IsGranted('ROLE_ELEVE')]
    public function catalogueAction(CoursRepository $coursRepository, ): Response
    {
        // Tous les cours sont récupérés pour être affichés dans le catalogue.
        $cours = $coursRepository->findAll();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        /** @var Eleve|null $eleve */
        $eleve = $user?->getEleve();
        
        $inscribedCourseIds = [];

        if ($eleve) {
            // Construit un tableau simple contenant les IDs des cours auxquels l'élève est inscrit.
            $inscribedCourseIds = $eleve->getInscription()
                ->map(fn(Inscription $i) => $i->getCours() ? $i->getCours()->getId() : null)
                ->filter(fn(?int $id) => $id !== null)
                ->toArray();
        }

        return $this->render('cours/catalogue_cours.html.twig', [
            'cours' => $cours,
            'titre' => 'Catalogue Complet des Cours',
            'inscribedCourseIds' => $inscribedCourseIds, // Passé au template pour l'état d'inscription
        ]);
    }

    // [AJOUT NOUVELLE ROUTE] Bascule l'inscription/désinscription
    /**
     * Bascule l'inscription/désinscription d'un élève à un cours spécifique.
     */
    #[Route('/toggle-inscription/{courseId}', name: 'app_cours_toggle_inscription', methods: ['GET'])]
    #[IsGranted('ROLE_ELEVE')]
    public function toggleInscription(
        int $courseId, 
        EntityManagerInterface $em,
        CoursRepository $coursRepository,
        InscriptionRepository $inscriptionRepository
    ): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        /** @var Eleve|null $eleve */
        $eleve = $user?->getEleve();
        
        if (!$eleve) {
            $this->addFlash('error', 'Votre compte utilisateur n\'est pas relié à une fiche élève.');
            return $this->redirectToRoute('app_catalogue');
        }

        $cours = $coursRepository->find($courseId);

        if (!$cours) {
            $this->addFlash('error', 'Le cours demandé n\'existe pas.');
            return $this->redirectToRoute('app_catalogue');
        }

        // Vérification de l'inscription existante
        $existingInscription = $inscriptionRepository->findOneBy([
            'eleve' => $eleve,
            'cours' => $cours,
        ]);

        if ($existingInscription) {
            // Désinscription
            $em->remove($existingInscription);
            $em->flush();
            $this->addFlash('success', 'Vous vous êtes désinscrit(e) du cours : ' . $cours->getLibelle());
        } else {
            // Inscription
            $inscription = new Inscription();
            $inscription->setEleve($eleve);
            $inscription->setCours($cours);

            $em->persist($inscription);
            $em->flush();
            $this->addFlash('success', 'Félicitations ! Vous êtes inscrit(e) au cours : ' . $cours->getLibelle());
        }

        return $this->redirectToRoute('app_catalogue');
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

    // --- ROUTES DYNAMIQUES (DOIVENT RESTER EN BAS) ---

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    
#[Route('/{id}/desinscription', name: 'app_unregister_course', methods: ['POST'])]
    #[IsGranted('ROLE_ELEVE')] // Protection d'accès aux non-élèves
    // ATTENTION: J'AI CHANGÉ LA DÉPENDANCE DE $security
    public function unregister(Cours $cour, Security $security, InscriptionRepository $inscriptionRepository, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $security->getUser();
        /** @var Eleve|null $eleve */
        $eleve = $user?->getEleve(); 

        // Cette vérification est redondante grâce à IsGranted, mais reste une bonne pratique
        if (!$eleve) {
            $this->addFlash('error', 'Vous devez être connecté en tant qu\'élève pour effectuer cette action.');
            return $this->redirectToRoute('app_cours_show', ['id' => $cour->getId()]);
        }

        // Trouver l'inscription existante en utilisant votre méthode personnalisée
        $inscription = $inscriptionRepository->findInscriptionByEleveAndCours($eleve, $cour);

        if (!$inscription) {
            $this->addFlash('warning', 'Erreur : Vous n\'étiez pas inscrit à ce cours.');
        } else {
            // Suppression de l'inscription
            $entityManager->remove($inscription);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez été désinscrit du cours "' . $cour->getTitre() . '" avec succès.');
        }

        // Redirection vers la page de détails du cours
        return $this->redirectToRoute('app_cours_show', ['id' => $cour->getId()]);
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