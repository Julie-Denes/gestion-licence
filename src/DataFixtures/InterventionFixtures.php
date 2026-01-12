<?php

namespace App\DataFixtures;

use App\Entity\Intervention;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InterventionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Titres et dates des interventions
        $interventionsData = [
            ['titre' => 'Introduction à la programmation', 'dateDebut' => '2024-09-05', 'dateFin' => '2024-09-10'],
            ['titre' => 'Travaux pratiques PHP', 'dateDebut' => '2024-10-01', 'dateFin' => '2024-10-05'],
            ['titre' => 'Projet encadré semestre 1', 'dateDebut' => '2024-11-15', 'dateFin' => '2024-12-15'],
        ];

        // Références aux entités existantes
        $modules = [
            $this->getReference('module_101'),
            $this->getReference('module_102'),
            $this->getReference('module_201'),
        ];

        $types = [
            $this->getReference('type_Cours magistral'),
            $this->getReference('type_Travaux dirigés'),
            $this->getReference('type_Projet encadré'),
        ];

        $enseignants = [
            $this->getReference('enseignant_1'),
            $this->getReference('enseignant_2'),
            $this->getReference('enseignant_3'),
        ];

        foreach ($interventionsData as $i => $data) {
            $intervention = new Intervention();
            $intervention->setTitre($data['titre']);
            $intervention->setDateDebut(new \DateTime($data['dateDebut']));
            $intervention->setDateFin(new \DateTime($data['dateFin']));

            // Lier Module et TypeIntervention
            $intervention->setModule($modules[$i % count($modules)]);
            $intervention->setTypeIntervention($types[$i % count($types)]);

            // Lier tous les enseignants
            foreach ($enseignants as $enseignant) {
                $intervention->addCorpsEnseignant($enseignant);
            }

            $manager->persist($intervention);
        }

        $manager->flush();
    }
}
