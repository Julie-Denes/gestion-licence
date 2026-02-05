<?php

namespace App\DataFixtures;

use App\Entity\Intervention;
use App\Entity\TypeIntervention;
use App\Entity\Module;
use App\Entity\CorpsEnseignant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InterventionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Titres et dates des interventions
        $interventionsData = [
            ['titre' => 'Introduction à la programmation', 'dateDebut' => '2024-09-05', 'dateFin' => '2024-09-05 02:00'],
            ['titre' => 'Travaux pratiques PHP', 'dateDebut' => '2024-10-01', 'dateFin' => '2024-10-01 03:00'],
            ['titre' => 'Projet encadré semestre 1', 'dateDebut' => '2024-11-15', 'dateFin' => '2024-11-15 04:00'],
        ];

        // Références aux entités existantes
        $modules = [
            $this->getReference('module_101', Module::class),
            $this->getReference('module_102', Module::class),
            $this->getReference('module_201', Module::class),
        ];

        $types = [
            $this->getReference('type_intervention_cours_magistral', TypeIntervention::class),
            $this->getReference('type_intervention_travaux_dirigés', TypeIntervention::class),
            $this->getReference('type_intervention_projet_encadré', TypeIntervention::class),
        ];

        $enseignants = [
            $this->getReference('enseignant_1', CorpsEnseignant::class ),
            $this->getReference('enseignant_2', CorpsEnseignant::class),
            $this->getReference('enseignant_3', CorpsEnseignant::class),
        ];

        foreach ($interventionsData as $i => $data) {
            $intervention = new Intervention();
            $intervention->setTitre($data['titre']);
            $intervention->setDateDebut(new \DateTimeImmutable($data['dateDebut']));
            $intervention->setDateFin(new \DateTimeImmutable($data['dateFin']));

            // Lier Module et TypeIntervention
            $intervention->setModule($modules[$i % count($modules)]);
            $intervention->setTypeIntervention($types[$i % count($types)]);

            // Lier tous les enseignants
            foreach ($enseignants as $enseignant) {
                $intervention->addCorpsEnseignant($enseignant);
                $enseignant->addIntervention($intervention);
            }

            $manager->persist($intervention);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModuleFixtures::class,
            TypeInterventionFixtures::class,
            CorpsEnseignantFixtures::class,
        ];
    }
}
