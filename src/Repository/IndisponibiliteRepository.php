<?php

namespace App\Repository;

use App\Entity\CorpsEnseignant;
use App\Entity\Indisponibilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class IndisponibiliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indisponibilite::class);
    }

    public function hasIndisponibilite(
        CorpsEnseignant $enseignant,
        \DateTimeInterface $dateDebut,
        \DateTimeInterface $dateFin
    ): bool
    {
        return $this->createQueryBuilder('i')

            ->andWhere('i.corpsEnseignant = :enseignant')

            ->andWhere('i.dateDebut < :dateFin')
            ->andWhere('i.dateFin > :dateDebut')

            ->setParameter('enseignant', $enseignant)
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)

            ->getQuery()
            ->getResult() !== [];
    }
}