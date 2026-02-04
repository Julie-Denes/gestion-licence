<?php

namespace App\Controller;

use App\Repository\InterventionRepository;
use App\Repository\ModuleRepository;
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

}
