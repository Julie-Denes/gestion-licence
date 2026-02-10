<?php

namespace App\Controller;


use App\Repository\AnneeScolaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\AnneeScolaire;
use App\Form\AnneeScolaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AnneeScolaireController extends AbstractController
{
    #[Route('/annees-scolaires', name: 'annees_scolaires')]
    public function index(AnneeScolaireRepository $annee): Response
    {
        $annees = $annee->findAll();

        return $this->render('annee_scolaire/AnneeScolaire.html.twig', [
            'annees' => $annees
        ]);
    }

    #[Route('/annees-scolaires/new', name: 'annee_scolaire_new')]
public function new(Request $request,EntityManagerInterface $em): Response {
    $annee = new AnneeScolaire();
    $form = $this->createForm(AnneeScolaireType::class, $annee);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($annee);
        $em->flush();

        $this->addFlash('success', 'Année scolaire ajoutée.');

        return $this->redirectToRoute('annees_scolaires');
    }

    return $this->render('annee_scolaire/new.html.twig', [
        'form' => $form,
    ]);
}

}
