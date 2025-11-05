<?php

namespace App\Controller;

use App\Entity\TypeInstrument;
use App\Form\TypeInstrumentType;
use App\Repository\TypeInstrumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/typeInstrument')]
final class TypeInstrumentController extends AbstractController
{
    #[Route(name: 'app_type_instrument_index', methods: ['GET'])]
    public function index(TypeInstrumentRepository $typeInstrumentRepository): Response
    {
        return $this->render('type_instrument/index.html.twig', [
            'type_instruments' => $typeInstrumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_instrument_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeInstrument = new TypeInstrument();
        $form = $this->createForm(TypeInstrumentType::class, $typeInstrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeInstrument);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_instrument/new.html.twig', [
            'type_instrument' => $typeInstrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_instrument_show', methods: ['GET'])]
    public function show(TypeInstrument $typeInstrument): Response
    {
        return $this->render('type_instrument/show.html.twig', [
            'type_instrument' => $typeInstrument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_instrument_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeInstrument $typeInstrument, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeInstrumentType::class, $typeInstrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_instrument_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_instrument/edit.html.twig', [
            'type_instrument' => $typeInstrument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_instrument_delete', methods: ['POST'])]
    public function delete(Request $request, TypeInstrument $typeInstrument, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeInstrument->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeInstrument);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_instrument_index', [], Response::HTTP_SEE_OTHER);
    }
}
