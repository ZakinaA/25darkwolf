<?php

namespace App\Controller;

use App\Entity\Accessoire;
use App\Form\AccessoireType;
use App\Repository\AccessoireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/accessoire')]
final class AccessoireController extends AbstractController
{
    #[Route(name: 'app_accessoire_index', methods: ['GET'])]
    public function index(AccessoireRepository $accessoireRepository): Response
    {
        return $this->render('accessoire/index.html.twig', [
            'accessoires' => $accessoireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_accessoire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $accessoire = new Accessoire();
        $form = $this->createForm(AccessoireType::class, $accessoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($accessoire);
            $entityManager->flush();

            return $this->redirectToRoute('app_accessoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accessoire/new.html.twig', [
            'accessoire' => $accessoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accessoire_show', methods: ['GET'])]
    public function show(Accessoire $accessoire): Response
    {
        return $this->render('accessoire/show.html.twig', [
            'accessoire' => $accessoire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_accessoire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Accessoire $accessoire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AccessoireType::class, $accessoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_accessoire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accessoire/edit.html.twig', [
            'accessoire' => $accessoire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_accessoire_delete', methods: ['POST'])]
    public function delete(Request $request, Accessoire $accessoire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accessoire->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($accessoire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_accessoire_index', [], Response::HTTP_SEE_OTHER);
    }
}
