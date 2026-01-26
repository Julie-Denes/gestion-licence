<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\AnneeScolaire;

class AnneeScolaireController extends AbstractController
{
    #[Route('/annees-scolaires', name: 'annees_scolaires')]
    public function index(): Response
    {
    
        return $this->render('AnneeScolaire.html.twig', [
            'annees' => $annees
        ]);
    }
}
