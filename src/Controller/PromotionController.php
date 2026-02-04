<?php

namespace App\Controller;

use App\Entity\AnneeScolaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PromotionController extends AbstractController
{
    #[Route('/annees-scolaires/{annee}', name: 'promotion_show')]
    public function show(AnneeScolaire $annee): Response
    {
        $semaines = [
            [
                'debut' => '01/09/2025',
                'fin' => '12/09/2025',
            ],
            [
                'debut' => '06/10/2025',
                'fin' => '10/10/2025',
            ],
            [
                'debut' => '03/11/2025',
                'fin' => '07/11/2025',
            ],
        ];

        return $this->render('promotion/promotion.html.twig', [
            'annee' => $annee,
            'semaines' => $semaines
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
}
