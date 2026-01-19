<?php

namespace App\Controller;

use App\Entity\CorpsEnseignant;
use App\Form\CorpsEnseignantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/corps-enseignant', name: 'corps_enseignant_')]
class CorpsEnseignantController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filtre = $request->query->get('filtre', '');
        
        $queryBuilder = $entityManager->getRepository(CorpsEnseignant::class)->createQueryBuilder('t');

        if (!empty($filtre)) {
            $queryBuilder->where('LOWER(t.nom) LIKE :filtre')
                        ->setParameter('filtre', '%' . strtolower($filtre) . '%');
        }

        $enseignants = $queryBuilder->getQuery()->getResult();

        return $this->render('corps_enseignant/index.html.twig', [
            'enseignants' => $enseignants,
            'filtre' => $filtre,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $corpsEnseignant = new CorpsEnseignant();
        $form = $this->createForm(CorpsEnseignantType::class, $corpsEnseignant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($corpsEnseignant);
            $em->flush();

            $this->addFlash('success', 'Enseignant ajouter avec succès !');

            return $this->redirectToRoute('corps_enseignant_list');
        }

        return $this->render('corps_enseignant/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => false,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(CorpsEnseignant $corpsEnseignant, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CorpsEnseignantType::class, $corpsEnseignant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($corpsEnseignant);
            $em->flush();

            $this->addFlash('success', 'Enseignant modifié avec succès !');

            return $this->redirectToRoute('corps_enseignant_list');
        }

        return $this->render('corps_enseignant/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(CorpsEnseignant $corpsEnseignant, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $corpsEnseignant->getId(), $request->request->get('_token'))) {
            $em->remove($corpsEnseignant);
            $em->flush();

            $this->addFlash('success', 'Enseignant supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Échec de la suppression : jeton CSRF invalide.');
        }

        return $this->redirectToRoute('corps_enseignant_list');
    }
}