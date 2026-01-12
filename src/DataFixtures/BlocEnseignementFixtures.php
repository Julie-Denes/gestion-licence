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
            ['code' => 101, 'nom' => 'Bloc Fondamental', 'description' => 'Cours de base pour tous les étudiants', 'nbHeure' => 120],
            ['code' => 102, 'nom' => 'Bloc Avancé', 'description' => 'Cours spécialisés avancés', 'nbHeure' => 150],
            ['code' => 201, 'nom' => 'Bloc Projet', 'description' => 'Projets et travaux pratiques', 'nbHeure' => 80],
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
