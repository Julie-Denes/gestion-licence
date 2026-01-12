<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blocFixtures = new BlocEnseignementFixtures();
        $blocFixtures->load($manager);

        $typeFixtures = new TypeInterventionFixtures();
        $typeFixtures->load($manager);

        
        $moduleFixtures = new ModuleFixtures();
        $moduleFixtures->load($manager);

        
        $enseignantFixtures = new CorpsEnseignantFixtures();
        $enseignantFixtures->load($manager);

        
        $anneeFixtures = new AnneeScolaireFixtures();
        $anneeFixtures->load($manager);

        
        $interventionFixtures = new InterventionFixtures();
        $interventionFixtures->load($manager);
    }

}
