<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use App\Repository\InstrumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/instrument')]
final class InstrumentController extends AbstractController
{
    #[Route(name: 'app_instrument_index', methods: ['GET'])]
    public function index(InstrumentRepository $instrumentRepository): Response
    {
        // 1. Récupère les instruments avec les relations pour l'affichage
        $instruments = $instrumentRepository->findAllWithRelations();
        
        // 2. Passe la variable 'instruments' (au pluriel) au template
        return $this->render('instrument/index.html.twig', [
            'instruments' => $instruments, 
        ]);
    }

    #[Route('/new', name: 'app_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // TODO: Implémenter le formulaire et la logique d'ajout
        // Placeholder pour l'exemple
        return $this->render('instrument/new.html.twig');
    }

    #[Route('/{id}', name: 'app_instrument_show', methods: ['GET'])]
    public function show(Instrument $instrument): Response
    {
        // TODO: Implémenter la vue détaillée
        return $this->render('instrument/show.html.twig', [
            'instrument' => $instrument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instrument $instrument, EntityManagerInterface $entityManager): Response
    {
        // 1. Création du formulaire (InstrumentType est maintenant connu)
        $form = $this->createForm(InstrumentType::class, $instrument);
        
        // 2. Gestion de la requête (Soumission du formulaire)
        $form->handleRequest($request);

        // 3. Logique de soumission
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'L\'instrument a été mis à jour avec succès.');
            return $this->redirectToRoute('app_instrument_show', ['id' => $instrument->getId()], Response::HTTP_SEE_OTHER);
        }

        // 4. Rendu de la vue
        return $this->render('instrument/edit.html.twig', [
            'instrument' => $instrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_instrument_delete', methods: ['POST'])]
    public function delete(Request $request, Instrument $instrument, EntityManagerInterface $entityManager): Response
    {
        // TODO: Implémenter la logique de suppression
        // Placeholder pour l'exemple
        return $this->redirectToRoute('app_instrument_index', [], Response::HTTP_SEE_OTHER);
    }
}
