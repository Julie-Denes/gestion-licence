<?php

namespace App\DataFixtures;

use App\Entity\CorpsEnseignant;
use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CorpsEnseignantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $enseignants = [
            ['nom' => 'Dupont', 'prenom' => 'Alice', 'email' => 'alice.dupont@example.com', 'nbHeure' => 20.0],
            ['nom' => 'Martin', 'prenom' => 'Jean', 'email' => 'jean.martin@example.com', 'nbHeure' => 18.5],
            ['nom' => 'Bernard', 'prenom' => 'Claire', 'email' => 'claire.bernard@example.com', 'nbHeure' => 22.0],
            ['nom' => 'Durand', 'prenom' => 'Paul', 'email' => 'paul.durand@example.com', 'nbHeure' => 15.0],
            ['nom' => 'Petit', 'prenom' => 'Sophie', 'email' => 'sophie.petit@example.com', 'nbHeure' => 25.0],
        ];

        $modulesRefs = ['module_101', 'module_102', 'module_201', 'module_202', 'module_301'];

        foreach ($enseignants as $i => $data) {
            $enseignant = new CorpsEnseignant();
            $enseignant->setNom($data['nom']);
            $enseignant->setPrenom($data['prenom']);
            $enseignant->setEmail($data['email']);
            $enseignant->setNbHeure($data['nbHeure']);

            $nbModules = random_int(1, 3);
            $modulesChoisis = array_rand($modulesRefs, $nbModules);

            if (!is_array($modulesChoisis))
            {
                $modulesChoisis = [$modulesChoisis];
            }

            foreach ($modulesChoisis as $key)
            {
                /** @var Module $module */
                $module = $this->getReference($modulesRefs[$key], Module::class);
                $enseignant->addModule($module);
            }

            $manager->persist($enseignant);

            $this->addReference('enseignant_' . ($i + 1), $enseignant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ModuleFixtures::class,
        ];
    }
}
