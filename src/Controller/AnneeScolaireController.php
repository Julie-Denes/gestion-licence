<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnneeScolaireController extends AbstractController
{
    #[Route('/annees-scolaires', name: 'annees_scolaires')]
    public function index(): Response
    {
        // remplacer ça par un repository 
        $annees = [
            [
                'promotion' => 2026,
                'saison' => '2026/2027',
            ],
            [
                'promotion' => 2025,
                'saison' => '2025/2026',
            ],
            [
                'promotion' => 2024,
                'saison' => '2024/2025',
            ],
        ];

        return $this->render('AnneeScolaire.html.twig', [
            'annees' => $annees
        ]);
    }
}
