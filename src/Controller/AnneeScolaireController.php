<?php

namespace App\Controller;


use App\Repository\AnneeScolaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnneeScolaireController extends AbstractController
{
    #[Route('/annees-scolaires', name: 'annees_scolaires')]
    public function index(AnneeScolaireRepository $annee): Response
    {
        $annees = $annee->findAll();

        return $this->render('AnneeScolaire.html.twig', [
            'annees' => $annees
        ]);
    }
}