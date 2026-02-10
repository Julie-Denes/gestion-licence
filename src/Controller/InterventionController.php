<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Repository\InterventionRepository;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InterventionController extends AbstractController
{
    #[Route('/interventions', name: 'interventions_list')]
public function index(
    Request $request,
    InterventionRepository $repo,
    ModuleRepository $moduleRepo
): Response {
    $page = max(1, $request->query->getInt('page', 1));
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $start = $request->query->get('start')
        ? new \DateTime($request->query->get('start'))
        : null;

    $end = $request->query->get('end')
        ? new \DateTime($request->query->get('end'))
        : null;

    $moduleId = $request->query->get('module')
        ? (int) $request->query->get('module')
        : null;

    // Récupère les interventions paginées
    $interventions = $repo->findFiltered(
        $start,
        $end,
        $moduleId,
        $limit,
        $offset
    );

    // Compte le total pour la pagination
    $total = $repo->countFiltered(
        $start,
        $end,
        $moduleId
    );

    $pages = ceil($total / $limit);

    return $this->render('intervention/index.html.twig', [
        'interventions' => $interventions,
        'modules' => $moduleRepo->findAll(),
        'page' => $page,
        'pages' => $pages
    ]);
}

#[Route('/interventions/new', name: 'intervention_new')]
public function new(
    Request $request,
    EntityManagerInterface $em
): Response {
    $intervention = new Intervention();
    $form = $this->createForm(InterventionType::class, $intervention);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $debut = $intervention->getDateDebut();
        $fin = $intervention->getDateFin();

      
        if ($fin <= $debut) {
            $this->addFlash('error', 'La date de fin doit être strictement supérieure à la date de début.');
            return $this->redirectToRoute('intervention_new');
        }

        $duree = ($fin->getTimestamp() - $debut->getTimestamp()) / 3600;
        if ($duree > 4) {
            $this->addFlash('error', 'La durée de l’intervention ne peut pas dépasser 4 heures.');
            return $this->redirectToRoute('intervention_new');
        }

        
        if ($debut->format('Y') !== $fin->format('Y')) {
            $this->addFlash('error', 'Les dates doivent appartenir à la même période de cours.');
            return $this->redirectToRoute('intervention_new');
        }

        
        $module = $intervention->getModule();
        foreach ($intervention->getCorpsEnseignants() as $enseignant) {
            if (!$enseignant->getModules()->contains($module)) {
                $this->addFlash(
                    'error',
                    "L’intervenant {$enseignant->getNom()} n’intervient pas sur ce module."
                );
                return $this->redirectToRoute('intervention_new');
            }
        }

        $em->persist($intervention);
        $em->flush();

        $this->addFlash('success', 'Intervention ajoutée avec succès.');

        return $this->redirectToRoute('calendrier');
    }

    return $this->render('intervention/new.html.twig', [
        'form' => $form,
    ]);
}


#[Route('/interventions/{id}/edit', name: 'intervention_edit')]
public function edit(
    Intervention $intervention,
    Request $request,
    EntityManagerInterface $em
): Response {
    $form = $this->createForm(InterventionType::class, $intervention);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $debut = $intervention->getDateDebut();
        $fin = $intervention->getDateFin();

        
        if ($fin <= $debut) {
            $this->addFlash('error', 'La date de fin doit être strictement supérieure à la date de début.');
            return $this->redirectToRoute('intervention_edit', ['id' => $intervention->getId()]);
        }

        
        $duree = ($fin->getTimestamp() - $debut->getTimestamp()) / 3600;
        if ($duree > 4) {
            $this->addFlash('error', 'La durée de l’intervention ne peut pas dépasser 4 heures.');
            return $this->redirectToRoute('intervention_edit', ['id' => $intervention->getId()]);
        }

        
        if ($debut->format('Y') !== $fin->format('Y')) {
            $this->addFlash('error', 'Les dates doivent appartenir à la même période de cours.');
            return $this->redirectToRoute('intervention_edit', ['id' => $intervention->getId()]);
        }

        
        $module = $intervention->getModule();
        foreach ($intervention->getCorpsEnseignants() as $enseignant) {
            if (!$enseignant->getModules()->contains($module)) {
                $this->addFlash(
                    'error',
                    "L’intervenant {$enseignant->getNom()} n’intervient pas sur ce module."
                );
                return $this->redirectToRoute('intervention_edit', ['id' => $intervention->getId()]);
            }
        }

        $em->flush();

        $this->addFlash('success', 'Intervention modifiée avec succès.');

        return $this->redirectToRoute('calendrier');
    }

    return $this->render('intervention/show.html.twig', [
        'form' => $form,
        'intervention' => $intervention,
    ]);
}

#[Route('/interventions/{id}/delete', name: 'intervention_delete', methods: ['POST'])]
public function delete(
    Intervention $intervention,
    EntityManagerInterface $em,
    Request $request
): Response {
    if ($this->isCsrfTokenValid('delete'.$intervention->getId(), $request->request->get('_token'))) {
        $em->remove($intervention);
        $em->flush();

        $this->addFlash('success', 'Intervention supprimée.');
    }

    return $this->redirectToRoute('calendrier');
}




}
