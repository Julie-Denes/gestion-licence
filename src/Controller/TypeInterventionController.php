<?php

namespace App\Controller;

use App\Entity\TypeIntervention;
use App\Form\TypeInterventionForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TypeInterventionRepository;

#[Route('/type-intervention', name: 'type_intervention_')]
class TypeInterventionController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(Request $request, TypeInterventionRepository $typeInterventionRepository): Response
    {
        $filtre = $request->query->get('filtre', '');
        
        $types = $typeInterventionRepository->findByFiltre($filtre);

        return $this->render('type_intervention/index.html.twig', [
            'types' => $types,
            'filtre' => $filtre,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, TypeInterventionRepository $typeInterventionRepository): Response
    {
        $typeIntervention = new TypeIntervention();
        $form = $this->createForm(TypeInterventionForm::class, $typeIntervention);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeInterventionRepository->save($typeIntervention, true);

            $this->addFlash('success', 'Type d’intervention créé avec succès !');

            return $this->redirectToRoute('type_intervention_list');
        }

        return $this->render('type_intervention/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => false,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(TypeIntervention $typeIntervention, Request $request, TypeInterventionRepository $typeInterventionRepository): Response
    {
        $form = $this->createForm(TypeInterventionForm::class, $typeIntervention);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeInterventionRepository->save($typeIntervention, true);

            $this->addFlash('success', 'Type d’intervention modifié avec succès !');

            return $this->redirectToRoute('type_intervention_list');
        }

        return $this->render('type_intervention/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(TypeIntervention $typeIntervention, TypeInterventionRepository $typeInterventionRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeIntervention->getId(), $request->request->get('_token'))) {
            $typeInterventionRepository->remove($typeIntervention, true);

            $this->addFlash('success', 'Type d’intervention supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Échec de la suppression : jeton CSRF invalide.');
        }

        return $this->redirectToRoute('type_intervention_list');
    }


}

