<?php

namespace App\Controller;

use App\Repository\InterventionRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CalendrierController extends AbstractController
{
    #[Route('/calendrier', name: 'calendrier')]
public function index(): Response
{
    return $this->render('calendrier/index.html.twig');
}



    #[Route('/calendrier/events', name: 'calendrier_events')]
    public function events(InterventionRepository $repo): Response
    {
        $events = [];

foreach ($repo->findAll() as $intervention) {

    $intervenants = [];
    foreach ($intervention->getCorpsEnseignants() as $enseignant) {
        $intervenants[] = $enseignant->getNom();
    }

    $events[] = [
        'title' =>
            $intervention->getModule()->getNom()
            . ' - ' . $intervention->getTypeIntervention()->getNom()
            . ' - ' . implode(', ', $intervenants),

        'start' => $intervention->getDateDebut()->format('Y-m-d H:i:s'),
        'end' => $intervention->getDateFin()->format('Y-m-d H:i:s'),

        'backgroundColor' => $intervention->getTypeIntervention()->getCouleur(),
        'borderColor' => $intervention->getTypeIntervention()->getCouleur(),

        'extendedProps' => [
            'visio' => false 
        ]
    ];
}


        return $this->json($events);
    }

    #[Route('/export/week', name: 'export_week')]
    public function exportWeek(InterventionRepository $repo): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            ['Date', 'Heure', 'Module', 'Intervenant', 'Type', 'Visio']
        ]);

        $row = 2;
        foreach ($repo->findThisWeek() as $i) {
            $sheet->fromArray([
                $i->getDateDebut()->format('d/m/Y'),
                $i->getDateDebut()->format('H:i'),
                $i->getModule()->getNom(),
                $i->getIntervenant()->getNom(),
                $i->getType()->getNom(),
                $i->isVisio() ? 'Oui' : 'Non'
            ], null, "A$row");

            $row++;
        }

        $writer = new Xls($spreadsheet);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set(
            'Content-Disposition',
            ResponseHeaderBag::DISPOSITION_ATTACHMENT . '; filename="planning-semaine.xls"'
        );

        ob_start();
        $writer->save('php://output');
        $response->setContent(ob_get_clean());

        return $response;
    }
}
