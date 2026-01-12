<?php

namespace App\DataFixtures;

use App\Entity\Module;
use App\Entity\BlocEnseignement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $modules = [
            [
                'code' => 101,
                'nom' => 'Mathématiques',
                'description' => 'Introduction aux mathématiques',
                'nbHeure' => 24.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_101'
            ],
            [
                'code' => 102,
                'nom' => 'Physique',
                'description' => 'Mécanique et thermodynamique',
                'nbHeure' => 30.0,
                'projetFilRouge' => true,
                'blocRef' => 'bloc_101'
            ],
            [
                'code' => 201,
                'nom' => 'Informatique',
                'description' => 'Algorithmes et programmation',
                'nbHeure' => 40.0,
                'projetFilRouge' => true,
                'blocRef' => 'bloc_102'
            ],
            [
                'code' => 202,
                'nom' => 'Chimie',
                'description' => 'Chimie générale',
                'nbHeure' => 28.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_102'
            ],
            [
                'code' => 301,
                'nom' => 'Électronique',
                'description' => 'Bases de l’électronique',
                'nbHeure' => 36.0,
                'projetFilRouge' => true,
                'blocRef' => 'bloc_201'
            ],
        ];

        foreach ($modules as $data) {
            $module = new Module();
            $module->setCode($data['code']);
            $module->setNom($data['nom']);
            $module->setDescription($data['description']);
            $module->setNbHeure($data['nbHeure']);
            $module->setProjetFilRouge($data['projetFilRouge']);
            $module->setBlocEnseignement($this->getReference($data['blocRef'], blocEnseignement::class));

            $manager->persist($module);
            $this->addReference('module_' . $data['code'], $module);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BlocEnseignementFixtures::class,
        ];
    }

}
