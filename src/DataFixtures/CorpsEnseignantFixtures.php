<?php

namespace App\DataFixtures;

use App\Entity\CorpsEnseignant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CorpsEnseignantFixtures extends Fixture
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

        foreach ($enseignants as $i => $data) {
            $enseignant = new CorpsEnseignant();
            $enseignant->setNom($data['nom']);
            $enseignant->setPrenom($data['prenom']);
            $enseignant->setEmail($data['email']);
            $enseignant->setNbHeure($data['nbHeure']);

            $manager->persist($enseignant);

            $this->addReference('enseignant_' . ($i + 1), $enseignant);
        }

        $manager->flush();
    }
}
