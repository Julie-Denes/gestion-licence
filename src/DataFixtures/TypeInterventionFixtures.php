<?php

namespace App\DataFixtures;

use App\Entity\TypeIntervention;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeInterventionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = [
            [
                'nom' => 'Cours magistral',
                'description' => 'Séance magistrale où l’enseignant expose le cours.',
                'couleur' => '#FF5733'
            ],
            [
                'nom' => 'Travaux dirigés',
                'description' => 'Séance encadrée pour résoudre des exercices en groupe.',
                'couleur' => '#33FF57'
            ],
            [
                'nom' => 'Travaux seul',
                'description' => 'Séance en autonomie.',
                'couleur' => '#3357FF'
            ],
            [
                'nom' => 'Projet encadré',
                'description' => 'Réalisation d’un projet sous supervision.',
                'couleur' => '#F1C40F'
            ],
            [
                'nom' => 'Soutenance',
                'description' => 'Présentation et évaluation d’un projet ou d’un mémoire.',
                'couleur' => '#8E44AD'
            ]
        ];

        foreach ($types as $data) {
            $type = new TypeIntervention();
            $type->setNom($data['nom']);
            $type->setDescription($data['description']);
            $type->setCouleur($data['couleur']);
            $manager->persist($type);

            $this->addReference('type_intervention_' . strtolower(str_replace(' ', '_', $data['nom'])), $type);
        }

        $manager->flush();
    }
}