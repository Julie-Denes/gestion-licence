<?php

namespace App\Repository;

use App\Entity\CorpsEnseignant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CorpsEnseignant>
 */
class CorpsEnseignantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorpsEnseignant::class);
    }

    public function findByFilters(?string $nom = '', ?string $prenom = '', ?string $email = ''): array
    {
        $qb = $this->createQueryBuilder('t');

        if (!empty($nom)) {
            $qb->andWhere('LOWER(t.nom) LIKE :nom')
               ->setParameter('nom', '%' . strtolower($nom) . '%');
        }

        if (!empty($prenom)) {
            $qb->andWhere('LOWER(t.prenom) LIKE :prenom')
               ->setParameter('prenom', '%' . strtolower($prenom) . '%');
        }

        if (!empty($email)) {
            $qb->andWhere('LOWER(t.email) LIKE :email')
               ->setParameter('email', '%' . strtolower($email) . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function save(CorpsEnseignant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CorpsEnseignant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
