<?php

namespace App\Repository;

use App\Entity\BlocEnseignement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlocEnseignement>
 */
class BlocEnseignementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlocEnseignement::class);
    }

    public function findByFilters(?string $filtreNom = '', ?string $filtreCode = ''): array
    {
        $qb = $this->createQueryBuilder('t');

        if (!empty($filtreNom)) {
            $qb->andWhere('LOWER(t.nom) LIKE :filtreNom')
               ->setParameter('filtreNom', '%' . strtolower($filtreNom) . '%');
        }

        if (!empty($filtreCode)) {
            $qb->andWhere('t.code LIKE :code')
               ->setParameter('code', '%' . $filtreCode . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function save(BlocEnseignement $blocEnseignement, bool $flush = false): void
    {
        $this->getEntityManager()->persist($blocEnseignement);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
