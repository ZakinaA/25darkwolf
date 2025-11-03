<?php

namespace App\Controller;

use App\Entity\ClasseInstrument;
use App\Form\ClasseInstrumentType;
use App\Repository\ClasseInstrumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/classe/instrument')]
final class ClasseInstrumentController extends AbstractController
{
    #[Route(name: 'app_classe_instrument_index', methods: ['GET'])]
    public function index(ClasseInstrumentRepository $classeInstrumentRepository): Response
    {
        return $this->render('classe_instrument/index.html.twig', [
            'classe_instruments' => $classeInstrumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_classe_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $classeInstrument = new ClasseInstrument();
        $form = $this->createForm(ClasseInstrumentType::class, $classeInstrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($classeInstrument);
            $entityManager->flush();

            return $this->redirectToRoute('app_classe_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classe_instrument/new.html.twig', [
            'classe_instrument' => $classeInstrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classe_instrument_show', methods: ['GET'])]
    public function show(ClasseInstrument $classeInstrument): Response
    {
        return $this->render('classe_instrument/show.html.twig', [
            'classe_instrument' => $classeInstrument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_classe_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClasseInstrument $classeInstrument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClasseInstrumentType::class, $classeInstrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_classe_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classe_instrument/edit.html.twig', [
            'classe_instrument' => $classeInstrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_classe_instrument_delete', methods: ['POST'])]
    public function delete(Request $request, ClasseInstrument $classeInstrument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classeInstrument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($classeInstrument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_classe_instrument_index', [], Response::HTTP_SEE_OTHER);
    }
}
