<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\BlocEnseignement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModuleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blocs = [
            ['nom' => 'Bloc 1', 'reference' => 'bloc_1'],
            ['nom' => 'Bloc 2', 'reference' => 'bloc_2'],
            ['nom' => 'Bloc 3', 'reference' => 'bloc_3'],
        ];

        foreach ($blocs as $blocData) {
            $bloc = new BlocEnseignement();
            $bloc->setNom($blocData['nom']);
            $manager->persist($bloc);

            $this->addReference($blocData['reference'], $bloc);
        }

        // Modules
        $modules = [
            ['code' => 101, 'nom' => 'Mathématiques', 'description' => 'Introduction aux mathématiques', 'nbHeure' => 24.0, 'projetFilRouge' => false, 'blocRef' => 'bloc_1'],
            ['code' => 102, 'nom' => 'Physique', 'description' => 'Mécanique et thermodynamique', 'nbHeure' => 30.0, 'projetFilRouge' => true, 'blocRef' => 'bloc_1'],
            ['code' => 201, 'nom' => 'Informatique', 'description' => 'Algorithmes et programmation', 'nbHeure' => 40.0, 'projetFilRouge' => true, 'blocRef' => 'bloc_2'],
            ['code' => 202, 'nom' => 'Chimie', 'description' => 'Chimie générale', 'nbHeure' => 28.0, 'projetFilRouge' => false, 'blocRef' => 'bloc_2'],
            ['code' => 301, 'nom' => 'Électronique', 'description' => 'Bases de l’électronique', 'nbHeure' => 36.0, 'projetFilRouge' => true, 'blocRef' => 'bloc_3'],
        ];

        foreach ($modules as $data) {
            $module = new Module();
            $module->setCode($data['code']);
            $module->setNom($data['nom']);
            $module->setDescription($data['description']);
            $module->setNbHeure($data['nbHeure']);
            $module->setProjetFilRouge($data['projetFilRouge']);
            $module->setBlocEnseignement($this->getReference($data['blocRef']));

            $manager->persist($module);
        }

        $manager->flush();
    }
}
