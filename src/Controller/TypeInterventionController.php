<?php

namespace App\Controller;

use App\Entity\TypeIntervention;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeInterventionController extends AbstractController
{
    #[Route('/type-intervention', name: 'app_type_intervention_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $types = $entityManager->getRepository(TypeIntervention::class)->findAll();

        return $this->render('type_intervention/index.html.twig', [
            'types' => $types,
        ]);
    }
}

