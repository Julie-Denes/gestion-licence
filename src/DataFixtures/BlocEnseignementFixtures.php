<?php

namespace App\DataFixtures;

use App\Entity\BlocEnseignement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlocEnseignementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blocsData = [
            ['code' => 'B1', 'nom' => 'Piloter', 'description' => 'Piloter un projet informatique', 'nbHeure' => 87.5],
            ['code' => 'B2', 'nom' => 'Coordonner', 'description' => 'Coordonner une équipe projet', 'nbHeure' => 105],
            ['code' => 'B3', 'nom' => 'Superviser', 'description' => 'Superviser la mise en oeuvre d\'un projet informatique', 'nbHeure' => 14],
            ['code' => 'B4', 'nom' => 'Coordoner', 'description' => 'Coordoner le cycle de vie des applications', 'nbHeure' => 297.5],
        ];

        foreach ($blocsData as $data) {
            $bloc = new BlocEnseignement();
            $bloc->setCode($data['code']);
            $bloc->setNom($data['nom']);
            $bloc->setDescription($data['description']);
            $bloc->setNbHeure($data['nbHeure']);

            $manager->persist($bloc);

            $this->addReference('bloc_' . $data['code'], $bloc);
        }

        $manager->flush();
    }
}
