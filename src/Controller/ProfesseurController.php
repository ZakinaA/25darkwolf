<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\User; // NÉCESSAIRE
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // NÉCESSAIRE
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/professeur')]
final class ProfesseurController extends AbstractController
{
    #[Route(name: 'app_professeur_index', methods: ['GET'])]
    public function index(ProfesseurRepository $professeurRepository): Response
    {
        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professeur_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher // NÉCESSAIRE
    ): Response
    {
        $professeur = new Professeur();
        $user = new User(); // NÉCESSAIRE : On crée un User
        $professeur->setUser($user); // NÉCESSAIRE : On le lie

        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // --- NÉCESSAIRE : Logique pour le User ---
            // On récupère le mot de passe en clair depuis le sous-formulaire
            $plainPassword = $form->get('user')->get('password')->getData();
            if ($plainPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }
            $user->setRoles(['ROLE_PROF']); // On définit le rôle
            // --- Fin de la logique User ---

            $entityManager->persist($user); // NÉCESSAIRE : On persiste aussi le User
            $entityManager->persist($professeur);
            $entityManager->flush();

            return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(), // CORRIGÉ
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_show', methods: ['GET'])]
    public function show(Professeur $professeur, ProfesseurRepository $professeurRepository): Response
    {
        // --- OPTIMISATION (pour charger les cours et éviter le N+1) ---
        $professeur = $professeurRepository->createQueryBuilder('p')
            ->leftJoin('p.cours', 'c')->addSelect('c')
            ->leftJoin('c.typeInstrument', 'ti')->addSelect('ti')
            ->leftJoin('c.jour', 'j')->addSelect('j')
            ->leftJoin('p.typeInstrument', 'pti')->addSelect('pti')
            ->where('p.id = :id')
            ->setParameter('id', $professeur->getId())
            ->getQuery()
            ->getOneOrNullResult();
        // --- FIN OPTIMISATION ---

        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeur $professeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form->createView(), // CORRIGÉ
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_delete', methods: ['POST'])]
    public function delete(Request $request, Professeur $professeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->getPayload()->getString('_token'))) {
            
            // --- AJOUT NÉCESSAIRE ---
            // On supprime aussi le User lié pour ne pas laisser d'orphelin
            $user = $professeur->getUser();
            if ($user) {
                $entityManager->remove($user);
            }
            // --- FIN AJOUT ---

            $entityManager->remove($professeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
    }

    // --- C'EST CETTE MÉTHODE QUI CRÉE LA ROUTE ---
    #[Route('/dashboard/{id}', name: 'app_professeur_dashboard', methods: ['GET'])]
    #[IsGranted('ROLE_PROF')]
    public function dashboard(ProfesseurRepository $professeurRepository): Response
    {
        // Récupérer les données nécessaires pour le tableau de bord
        $user = $this->getUser();
        
        // On cherche par l'ID de l'utilisateur (plus robuste)
        $professeur = $professeurRepository->findOneBy(['user' => $user->getId()]);

        if (!$professeur) {
            $this->addFlash('error', 'Professeur non trouvé.');
            // (Assurez-vous que la route 'app_home' existe !)
            return $this->redirectToRoute('app_home'); 
        }

        // C'est ici qu'on affiche votre template
        return $this->render('professeur/dashboard.html.twig', [
            'professeur' => $professeur,
        ]);
    }
}