<?php

namespace App\Controller;

use App\Entity\BlocEnseignement;
use App\Form\BlocEnseignementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BlocEnseignementRepository;

#[Route('/bloc-enseignement', name: 'bloc_enseignement_')]
class BlocEnseignementController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(Request $request, BlocEnseignementRepository $blocEnseignementRepository): Response
    {
        $filtreNom = $request->query->get('filtreNom', '');
        $filtreCode = $request->query->get('filtreCode', '');

        $enseignements = $blocEnseignementRepository->findByFilters($filtreNom, $filtreCode);

        return $this->render('bloc_enseignement/index.html.twig', [
            'enseignements' => $enseignements,
            'filtreNom' => $filtreNom,
            'filtreCode' => $filtreCode,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(BlocEnseignement $blocEnseignement, Request $request, BlocEnseignementRepository $blocEnseignementRepository): Response
    {
        $form = $this->createForm(BlocEnseignementType::class, $blocEnseignement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blocEnseignementRepository->save($blocEnseignement, true);

            $this->addFlash('success', 'Bloc d’Enseignement modifié avec succès !');

            return $this->redirectToRoute('bloc_enseignement_list');
        }

        return $this->render('bloc_enseignement/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
        ]);
    }
}