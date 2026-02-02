<?php

namespace App\Repository;

use App\Entity\TypeIntervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeIntervention>
 */
class TypeInterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeIntervention::class);
    }

    public function findByFiltre(?string $filtre = ''): array
    {
        $qb = $this->createQueryBuilder('t');

        if (!empty($filtre)) {
            $qb->andWhere('LOWER(t.nom) LIKE :filtre')
               ->setParameter('filtre', '%' . strtolower($filtre) . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function save(TypeIntervention $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeIntervention $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
