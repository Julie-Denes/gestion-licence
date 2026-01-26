<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/module', name: 'module_')]
class ModuleController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $modules = $entityManager->getRepository(Module::class)->findAll();

        // Regrouper les modules par bloc d’enseignement
        $modulesParBloc = [];
        foreach ($modules as $module) {
            $blocNom = $module->getBlocEnseignement()->getDescription();
            $modulesParBloc[$blocNom][] = $module;
        }

        return $this->render('module/index.html.twig', [
            'modulesParBloc' => $modulesParBloc,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);
            $em->flush();

            $this->addFlash('success', 'Module ajouté avec succès !');
            return $this->redirectToRoute('module_list');
        }

        return $this->render('module/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => false,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Module $module, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($module);
            $em->flush();

            $this->addFlash('success', 'Module modifié avec succès !');
            return $this->redirectToRoute('module_list');
        }

        return $this->render('module/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => true,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Module $module, Request $request, EntityManagerInterface $em): Response
    {
        // Empêcher la suppression d’un module qui a des enfants
        if (count($module->getEnfants()) > 0) {
            $this->addFlash('error', 'Impossible de supprimer ce module car il possède des sous-modules.');
            return $this->redirectToRoute('module_list');
        }

        if ($this->isCsrfTokenValid('delete' . $module->getId(), $request->request->get('_token'))) {
            $em->remove($module);
            $em->flush();

            $this->addFlash('success', 'Module supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Échec de la suppression : jeton CSRF invalide.');
        }

        return $this->redirectToRoute('module_list');
    }

    
    #[Route('/parents-by-bloc/{id}', name: 'parents_by_bloc', methods: ['GET'])]
    public function getParentsByBloc(int $id, EntityManagerInterface $em): JsonResponse
    {
        $modules = $em->getRepository(Module::class)
            ->createQueryBuilder('m')
            ->where('m.blocEnseignement = :id')
            ->orderBy('m.code', 'ASC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        $data = array_map(fn(Module $m) => [
            'id' => $m->getId(),
            'nom' => $m->getCode() . ' - ' . $m->getNom(),
        ], $modules);

        return new JsonResponse($data);
    }

}
