<?php

namespace App\Controller;

use App\Entity\ContratPret;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContratPretController extends AbstractController
{
    #[Route('/prets', name: 'app_contrat_pret')]
    public function index(EntityManagerInterface $em): Response
    {
        $prets = $em->getRepository(ContratPret::class)->findAll();

        return $this->render('contrat_pret/index.html.twig', [
            'prets' => $prets,
        ]);
    }

    #[Route('/prets/{id}', name: 'app_contrat_pret_show')]
    public function show(EntityManagerInterface $em, int $id): Response
    {
        $pret = $em->getRepository(ContratPret::class)->find($id);

        if (!$pret) {
            throw $this->createNotFoundException('Le contrat de prêt n\'existe pas.');
        }

        return $this->render('contrat_pret/show.html.twig', [
            'pret' => $pret,
        ]);
    }
}
