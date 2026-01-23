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
                'nom' => 'Gestion_projet',
                'description' => 'Gestion de projet - Méthode Agile',
                'nbHeure' => 63.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => null,
            ],
            [
                'code' => 102,
                'nom' => 'Cadre_légal',
                'description' => 'Cadre légal - Droit numérique',
                'nbHeure' => 21.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => null,
            ],
            [
                'code' => 121,
                'nom' => 'RGPD',
                'description' => 'RGPD',
                'nbHeure' => 5.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => 102,
            ],
            [
                'code' => 122,
                'nom' => 'Propriété_intellectuelle',
                'description' => 'Propriété intellectuelle',
                'nbHeure' => 6.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => 102,
            ],
            [
                'code' => 123,
                'nom' => 'RSE',
                'description' => 'RSE',
                'nbHeure' => 10.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => 102,
            ],
            [
                'code' => 124,
                'nom' => 'Accessibilité',
                'description' => 'Accesibilité',
                'nbHeure' => 15.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => 102,
            ],
            [
                'code' => 103,
                'nom' => 'Eco-Conception',
                'description' => 'Eco-Conception',
                'nbHeure' => 3.5,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B1',
                'parentCode' => null,
            ],
            [
                'code' => 201,
                'nom' => 'Anglais',
                'description' => 'Anglais - Préparation au TOEIC',
                'nbHeure' => 17.5,
                'projetFilRouge' => true,
                'blocRef' => 'bloc_B2',
                'parentCode' => null,
            ],
            [
                'code' => 202,
                'nom' => 'Communication',
                'description' => 'Communication - Soft Skills',
                'nbHeure' => 28.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => null,
            ],
            [
                'code' => 203,
                'nom' => 'Devops_Cybersécurité',
                'description' => 'Devopts et Cybersécurité',
                'nbHeure' => 56.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => null,
            ],
            [
                'code' => 231,
                'nom' => 'Environnement_travail',
                'description' => 'Environnement de travail',
                'nbHeure' => 7.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => 203,
            ],
            [
                'code' => 232,
                'nom' => 'Environnement_production',
                'description' => 'Environnement de production',
                'nbHeure' => 7.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => 203,
            ],
            [
                'code' => 233,
                'nom' => 'Docker',
                'description' => 'Docker',
                'nbHeure' => 14.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => 203,
            ],
            [
                'code' => 234,
                'nom' => 'Devops_Cyber',
                'description' => 'Devops/Cyber',
                'nbHeure' => 21.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => 203,
            ],
            [
                'code' => 204,
                'nom' => 'Retour_expérience_REX',
                'description' => 'Retour d\'expérience (REX)',
                'nbHeure' => 3.5,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => null,
            ],
            [
                'code' => 241,
                'nom' => 'Conférence',
                'description' => 'Conférence',
                'nbHeure' => 3.5,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B2',
                'parentCode' => 204,
            ],
            [
                'code' => 301,
                'nom' => 'Redaction',
                'description' => 'Rédaction de compte rendus d\'activité',
                'nbHeure' => 14.0,
                'projetFilRouge' => false,
                'blocRef' => 'bloc_B3',
                'parentCode' => null,
            ],
        ];

        foreach ($modules as $data) {
            $module = new Module();
            $module->setCode($data['code']);
            $module->setNom($data['nom']);
            $module->setDescription($data['description']);
            $module->setNbHeure($data['nbHeure']);
            $module->setProjetFilRouge($data['projetFilRouge']);
            $module->setBlocEnseignement($this->getReference($data['blocRef'], BlocEnseignement::class));

            $manager->persist($module);
            $this->addReference('module_' . $data['code'], $module);
        }

        $manager->flush();

        foreach ($modules as $data) 
        {
            if (!empty($data['parentCode']))
            {
                /** @var Module $module */
                $module = $this->getReference('module_' . $data['code'], Module::class);
                /** @var Module $parent */
                $parent = $this->getReference('module_' . $data['parentCode'], Module::class);
                $module->setParent($parent);
                $manager->persist($module);
            }
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
