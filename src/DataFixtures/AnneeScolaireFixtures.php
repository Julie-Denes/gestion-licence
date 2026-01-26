<?php

namespace App\DataFixtures;

use App\Entity\AnneeScolaire;
use App\Entity\CoursPeriode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnneeScolaireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Définition des années scolaires
        $annees = [
            ['nom' => '2024-2025', 'dateDebut' => '2024-09-01', 'dateFin' => '2025-06-30'],
            ['nom' => '2025-2026', 'dateDebut' => '2025-09-01', 'dateFin' => '2026-06-30'],
            ['nom' => '2026-2027', 'dateDebut' => '2026-09-01', 'dateFin' => '2027-06-30'],
        ];

        foreach ($annees as $i => $data) {
            $annee = new AnneeScolaire();
            $annee->setNom($data['nom']);
            $annee->setDateDebut(new \DateTimeImmutable($data['dateDebut']));
            $annee->setDateFin(new \DateTimeImmutable($data['dateFin']));

            // Ajout de 1 à 3 périodes de cours par année
            $periodesData = [
                ['2024-09-01', '2024-12-15'],
                ['2025-01-05', '2025-03-30'],
                ['2025-04-05', '2025-06-30']
            ];

            foreach ($periodesData as $periodeDates) {
                $coursPeriode = new CoursPeriode();
                $coursPeriode->setDateDebut(new \DateTimeImmutable($periodeDates[0]));
                $coursPeriode->setDateFin(new \DateTimeImmutable($periodeDates[1]));
                $coursPeriode->setAnneeScolaire($annee);

                $manager->persist($coursPeriode);
                $annee->ajouterCoursPeriode($coursPeriode);
            }

            $manager->persist($annee);
        }

        $manager->flush();
    }
}
