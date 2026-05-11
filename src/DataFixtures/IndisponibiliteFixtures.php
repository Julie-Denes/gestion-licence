<?php

namespace App\DataFixtures;

use App\Entity\Indisponibilite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CorpsEnseignant;

class IndisponibiliteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $enseignant = $this->getReference('enseignant_1', CorpsEnseignant::class);

        $indispo = new Indisponibilite();

        $indispo->setTitre('Congé');

        $indispo->setDateDebut(
            new \DateTime('2026-05-10 08:00:00')
        );

        $indispo->setDateFin(
            new \DateTime('2026-05-10 18:00:00')
        );

        $indispo->setCorpsEnseignant($enseignant);

        $manager->persist($indispo);

        $manager->flush();
    }
}