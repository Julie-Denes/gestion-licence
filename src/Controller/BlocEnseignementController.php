<?php

namespace App\Controller;

use App\Entity\BlocEnseignement;
use App\Form\BlocEnseignementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bloc-enseignement', name: 'bloc_enseignement_')]
class BlocEnseignementController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filtreNom = $request->query->get('filtreNom', '');
        $filtreCode = $request->query->get('filtreCode', '');

        $queryBuilder = $entityManager->getRepository(BlocEnseignement::class)->createQueryBuilder('t');

        if(!empty($filtreNom)) 
        {
            $queryBuilder->where('LOWER(t.nom) LIKE :filtreNom')
                        ->setParameter('filtreNom', '%' . strtolower($filtreNom) . '%');
        }

        if (!empty($filtreCode)) {
        $queryBuilder->andWhere('t.code LIKE :code')
           ->setParameter('code', '%' . $filtreCode . '%');
    }

        $enseignements = $queryBuilder->getQuery()->getResult();

        return $this->render('bloc_enseignement/index.html.twig', [
            'enseignements' => $enseignements,
            'filtreNom' => $filtreNom,
            'filtreCode' => $filtreCode,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(BlocEnseignement $blocEnseignement, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BlocEnseignementType::class, $blocEnseignement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($blocEnseignement);
            $em->flush();

            $this->addFlash('success', 'Bloc d’Enseignement modifié avec succès !');

            return $this->redirectToRoute('bloc_enseignement_list');
        }

        return $this->render('bloc_enseignement/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
        ]);
    }
}