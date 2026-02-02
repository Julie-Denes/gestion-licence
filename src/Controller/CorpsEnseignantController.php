<?php

namespace App\Controller;

use App\Entity\CorpsEnseignant;
use App\Form\CorpsEnseignantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CorpsEnseignantRepository;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

#[Route('/corps-enseignant', name: 'corps_enseignant_')]
class CorpsEnseignantController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(Request $request, CorpsEnseignantRepository $corpsEnseignantRepository): Response
    {
        $filtreNom = $request->query->get('filtreNom', '');
        $filtrePrenom = $request->query->get('filtrePrenom', '');
        $filtreEmail = $request->query->get('filtreEmail', '');

        $enseignants = $corpsEnseignantRepository->findByFilters($filtreNom, $filtrePrenom, $filtreEmail);

        return $this->render('corps_enseignant/index.html.twig', [
            'enseignants' => $enseignants,
            'filtreNom' => $filtreNom,
            'filtrePrenom' => $filtrePrenom,
            'filtreEmail' => $filtreEmail,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, CorpsEnseignantRepository $corpsEnseignantRepository): Response
    {
        $corpsEnseignant = new CorpsEnseignant();
        $form = $this->createForm(CorpsEnseignantType::class, $corpsEnseignant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $corpsEnseignantRepository->save($corpsEnseignant, true);

            $this->addFlash('success', 'Enseignant ajouter avec succès !');

            return $this->redirectToRoute('corps_enseignant_list');
        }

        return $this->render('corps_enseignant/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => false,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(CorpsEnseignant $corpsEnseignant, Request $request, CorpsEnseignantRepository $corpsEnseignantRepository): Response
    {
        $form = $this->createForm(CorpsEnseignantType::class, $corpsEnseignant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $corpsEnseignantRepository->save($corpsEnseignant, true);

            $this->addFlash('success', 'Enseignant modifié avec succès !');

            return $this->redirectToRoute('corps_enseignant_list');
        }

        $interventions = $corpsEnseignant->getInterventions();

        return $this->render('corps_enseignant/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
            'interventions' => $interventions,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(CorpsEnseignant $corpsEnseignant, CorpsEnseignantRepository $corpsEnseignantRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $corpsEnseignant->getId(), $request->request->get('_token'))) {
            $corpsEnseignantRepository->remove($corpsEnseignant, true);

            $this->addFlash('success', 'Enseignant supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Échec de la suppression : jeton CSRF invalide.');
        }

        return $this->redirectToRoute('corps_enseignant_list');
    }


    #[Route('/export/{id}', name: 'export_interventions')]
    public function export(CorpsEnseignant $corpsEnseignant): Response
    {
    $interventions = $corpsEnseignant->getInterventions();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // En-têtes
    $sheet->setCellValue('A1', 'Date');
    $sheet->setCellValue('B1', 'Heure');
    $sheet->setCellValue('C1', 'Module');
    $sheet->setCellValue('D1', 'Type');
    $sheet->setCellValue('E1', 'Autres intervenants');

    // Remplir les lignes
    $row = 2;
    foreach ($interventions as $intervention) {
        $date = $intervention->getDateDebut()->format('d/m');
        $heure = $intervention->getDateDebut()->format('H:i') . ' - ' . $intervention->getDateFin()->format('H:i');
        $module = $intervention->getModule()->getNom();
        $type = $intervention->getTypeIntervention()->getNom();

        $autres = [];
        foreach ($intervention->getCorpsEnseignants() as $enseignant) {
            if ($enseignant->getId() !== $corpsEnseignant->getId()) {
                $autres[] = $enseignant->getPrenom() . ' ' . $enseignant->getNom();
            }
        }
        $autresTxt = count($autres) ? implode(', ', $autres) : 'Aucun autre intervenant';

        $sheet->setCellValue('A' . $row, $date);
        $sheet->setCellValue('B' . $row, $heure);
        $sheet->setCellValue('C' . $row, $module);
        $sheet->setCellValue('D' . $row, $type);
        $sheet->setCellValue('E' . $row, $autresTxt);

        $row++;
    }

    // Auto-size pour toutes les colonnes
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Style en-têtes
    $headerStyle = [
        'font' => ['bold' => true],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    ];
    $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

    // Bordures et alignement pour toutes les données
    $dataStyle = [
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
    ];
    $sheet->getStyle('A2:E' . ($row - 1))->applyFromArray($dataStyle);

    // Générer le fichier .xls
    $writer = new Xls($spreadsheet);
    $response = new Response();
    $response->headers->set('Content-Type', 'application/vnd.ms-excel');
    $response->headers->set('Content-Disposition', 'attachment;filename="interventions_' . $corpsEnseignant->getNom() . '.xls"');
    $response->headers->set('Cache-Control', 'max-age=0');

    ob_start();
    $writer->save('php://output');
    $content = ob_get_clean();
    $response->setContent($content);

    return $response;
    }


}