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
        // Récupérer tous les contrats de prêt
        $prets = $em->getRepository(ContratPret::class)->findAll();

        // Envoyer à la vue Twig
        return $this->render('contrat_pret/index.html.twig', [
            'prets' => $prets,
        ]);
    }
}
