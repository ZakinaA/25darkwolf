<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType; // <-- AJOUTEZ CE "USE"
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
        // Votre requête personnalisée est une bonne pratique, gardez-la.
        // Assurez-vous que la méthode findAllWithRelations() existe dans votre Repository.
        // Sinon, remplacez par : $instruments = $instrumentRepository->findAll();
        $instruments = $instrumentRepository->findAll(); 
        
        return $this->render('instrument/index.html.twig', [
            'instruments' => $instruments, 
        ]);
    }

    #[Route('/new', name: 'app_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // 1. Crée un nouvel objet Instrument
        $instrument = new Instrument();
        
        // 2. Crée le formulaire en le liant à l'objet et à votre InstrumentType
        $form = $this->createForm(InstrumentType::class, $instrument);
        
        // 3. Gère la requête (vérifie si le formulaire a été soumis)
        $form->handleRequest($request);

        // 4. Si le formulaire est soumis ET valide
        if ($form->isSubmitted() && $form->isValid()) {
            // 5. Sauvegarde l'objet en base de données
            $entityManager->persist($instrument);
            $entityManager->flush();

            // 6. Redirige vers la liste des instruments
            return $this->redirectToRoute('app_instrument_index');
        }

        // 7. Si ce n'est pas soumis (ou pas valide), affiche la page du formulaire
        return $this->render('instrument/new.html.twig', [
            'instrument' => $instrument,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_instrument_show', methods: ['GET'])]
    public function show(Instrument $instrument): Response
    {
        // Votre code existant est parfait
        return $this->render('instrument/show.html.twig', [
            'instruments' => $instrument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instrument $instrument, EntityManagerInterface $entityManager): Response
    {
        // 1. Crée le formulaire (pas besoin de new Instrument, Symfony le trouve avec l'ID)
        $form = $this->createForm(InstrumentType::class, $instrument);
        
        // 2. Gère la requête
        $form->handleRequest($request);

        // 3. Si soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // 4. Sauvegarde (pas besoin de "persist" sur un objet déjà existant)
            $entityManager->flush();

            // 5. Redirige
            return $this->redirectToRoute('app_instrument_index');
        }

        // 6. Affiche la page d'édition
        return $this->render('instrument/edit.html.twig', [
            'instruments' => $instrument,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_instrument_delete', methods: ['POST'])]
    public function delete(Request $request, Instrument $instrument, EntityManagerInterface $entityManager): Response
    {
        // Logique de suppression (vous en aurez besoin plus tard)
        if ($this->isCsrfTokenValid('delete'.$instrument->getId(), $request->request->get('_token'))) {
            $entityManager->remove($instrument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_instrument_index');
    }
}