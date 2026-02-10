<?php

namespace App\Controller;

use App\Entity\AnneeScolaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\CoursPeriode;
use App\Form\CoursPeriodeType;


class PromotionController extends AbstractController
{
#[Route('/annees-scolaires/{annee}', name: 'promotion_show')]
public function show(AnneeScolaire $annee): Response
{
    return $this->render('promotion/promotion.html.twig', [
        'annee' => $annee,
    ]);
}

    #[Route('/annees-scolaires/{id}/delete', name: 'annee_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        AnneeScolaire $annee,
        EntityManagerInterface $em
    ): Response
    {
        // Sécurité CSRF
        if ($this->isCsrfTokenValid('delete'.$annee->getId(), $request->request->get('_token'))) {
            $em->remove($annee);
            $em->flush();

            $this->addFlash('success', 'Année scolaire supprimée avec succès.');
        }

        return $this->redirectToRoute('annees_scolaires');
    }


    #[Route('/annees-scolaires/{id}/semaines/new', name: 'semaine_new')]
    public function new(
        AnneeScolaire $annee,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $semaine = new CoursPeriode();
        $semaine->setAnneeScolaire($annee);

        $form = $this->createForm(CoursPeriodeType::class, $semaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($semaine);
            $em->flush();

            $this->addFlash('success', 'Semaine de cours ajoutée');

            return $this->redirectToRoute('promotion_show', [
                'annee' => $annee->getId()
            ]);
        }

        return $this->render('promotion/new.html.twig', [
            'form' => $form,
            'annee' => $annee,
        ]);
    }

        #[Route('/annees-scolaires/{anneeId}/semaines/{id}/edit', name: 'semaine_edit')]
    public function edit(
        int $anneeId,
        CoursPeriode $semaine,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(CoursPeriodeType::class, $semaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Semaine de cours modifiée avec succès.');

            return $this->redirectToRoute('promotion_show', ['annee' => $anneeId]);
        }

        return $this->render('promotion/edit.html.twig', [
            'form' => $form,
            'semaine' => $semaine,
            'anneeId' => $anneeId,
        ]);
    }

     #[Route('/annees-scolaires/{anneeId}/semaines/{id}/delete', name: 'semaine_delete', methods: ['POST'])]
    public function deleteSemaine(
        int $anneeId,
        CoursPeriode $semaine,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$semaine->getId(), $request->request->get('_token'))) {
            $em->remove($semaine);
            $em->flush();
            $this->addFlash('success', 'Semaine de cours supprimée avec succès.');
        }

        return $this->redirectToRoute('promotion_show', ['annee' => $anneeId]);
    }

}
