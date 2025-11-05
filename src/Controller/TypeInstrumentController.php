<?php

namespace App\Controller;

use App\Entity\TypeInstrument;
use App\Form\TypeInstrumentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type-instrument')]
class TypeInstrumentController extends AbstractController
{
    /**
     * Affiche la liste de tous les TypeInstrument.
     */
    #[Route('/', name: 'app_type_instrument_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $typeInstruments = $entityManager
            ->getRepository(TypeInstrument::class)
            ->findAll();

        return $this->render('type_instrument/index.html.twig', [
            'type_instruments' => $typeInstruments,
        ]);
    }

    /**
     * Crée un nouveau TypeInstrument.
     */
    #[Route('/new', name: 'app_type_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeInstrument = new TypeInstrument();
        $form = $this->createForm(TypeInstrumentType::class, $typeInstrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeInstrument);
            $entityManager->flush();

            $this->addFlash('success', 'Le type d\'instrument a été créé avec succès.');
            return $this->redirectToRoute('app_type_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_instrument/new.html.twig', [
            'type_instrument' => $typeInstrument,
            'form' => $form,
        ]);
    }

    /**
     * Affiche les détails d'un TypeInstrument.
     */
    #[Route('/{id}', name: 'app_type_instrument_show', methods: ['GET'])]
    public function show(TypeInstrument $typeInstrument): Response
    {
        return $this->render('type_instrument/show.html.twig', [
            'type_instrument' => $typeInstrument,
        ]);
    }

    /**
     * Modifie un TypeInstrument existant.
     */
    #[Route('/{id}/edit', name: 'app_type_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeInstrument $typeInstrument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeInstrumentType::class, $typeInstrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le type d\'instrument a été mis à jour.');
            return $this->redirectToRoute('app_type_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_instrument/edit.html.twig', [
            'type_instrument' => $typeInstrument,
            'form' => $form,
        ]);
    }

    /**
     * Supprime un TypeInstrument.
     */
    #[Route('/{id}', name: 'app_type_instrument_delete', methods: ['POST'])]
    public function delete(Request $request, TypeInstrument $typeInstrument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeInstrument->getId(), $request->request->get('_token'))) {
            $entityManager->remove($typeInstrument);
            $entityManager->flush();
            $this->addFlash('success', 'Le type d\'instrument a été supprimé.');
        }

        return $this->redirectToRoute('app_type_instrument_index', [], Response::HTTP_SEE_OTHER);
    }
}