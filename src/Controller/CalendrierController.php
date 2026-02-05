<?php

namespace App\Controller;

use App\Repository\InterventionRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

use App\Entity\BlocEnseignement;
use App\Form\BlocEnseignementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            $intervenants = implode(', ', array_map(
                fn($c) => $c->getNom(),
                $intervention->getCorpsEnseignants()->toArray()
            ));

            $events[] = [
                'title' => $intervention->getModule()->getNom()
                    . ' - ' . $intervention->getTypeIntervention()->getNom()
                    . ' - ' . $intervenants,
                'start' => $intervention->getDateDebut()->format('Y-m-d\TH:i:s'),
                'end' => $intervention->getDateFin()->format('Y-m-d\TH:i:s'),
                'backgroundColor' => $intervention->getTypeIntervention()->getCouleur(),
                'borderColor' => $intervention->getTypeIntervention()->getCouleur(),
                'extendedProps' => [
                    'visio' => false // ou $intervention->isVisio() si tu l'actives
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
                implode(', ', array_map(fn($c) => $c->getNom(), $i->getCorpsEnseignants()->toArray())),
                $i->getTypeIntervention()->getNom(),
                false ? 'Oui' : 'Non'
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
