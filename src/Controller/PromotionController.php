<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PromotionController extends AbstractController
{
    #[Route('/annees-scolaires/annee', name: 'promotion_show')]
    public function show(int $annee): Response
    {
        // Données (BDD plus tard)
        $promotion = [
            'annee' => $annee,
            'saison' => $annee . '/' . ($annee + 1),
        ];

        $semaines = [
            [
                'debut' => '01/09/2025',
                'fin' => '12/09/2025',
            ],
            [
                'debut' => '06/10/2025',
                'fin' => '10/10/2025',
            ],
            [
                'debut' => '03/11/2025',
                'fin' => '07/11/2025',
            ],
        ];

        return $this->render('promotion/show.html.twig', [
            'promotion' => $promotion,
            'semaines' => $semaines
        ]);
    }
}