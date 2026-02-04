<?php
/*
namespace App\Repository;
use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    public function findThisWeek(): array
{
    $start = new \DateTime();
    $start->modify('monday this week')->setTime(0, 0, 0);

    $end = new \DateTime();
    $end->modify('sunday this week')->setTime(23, 59, 59);

    return $this->createQueryBuilder('i')
        ->where('i.dateDebut BETWEEN :start AND :end')
        ->setParameter('start', $start)
        ->setParameter('end', $end)
        ->getQuery()
        ->getResult();
}


}   */





namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    /**
     * Retourne les interventions filtrées avec pagination
     */
    public function findFiltered(
        ?\DateTimeInterface $start,
        ?\DateTimeInterface $end,
        ?int $moduleId,
        int $limit,
        int $offset
    ): array {
        $qb = $this->createQueryBuilder('i')
            ->leftJoin('i.module', 'm')
            ->leftJoin('i.typeIntervention', 't')
            ->leftJoin('i.corpsEnseignants', 'c')
            ->addSelect('m', 't', 'c')
            ->orderBy('i.dateDebut', 'DESC');

        if ($start) {
            $qb->andWhere('i.dateDebut >= :start')
               ->setParameter('start', $start);
        }

        if ($end) {
            $qb->andWhere('i.dateFin <= :end')
               ->setParameter('end', $end);
        }

        if ($moduleId) {
            $qb->andWhere('m.id = :moduleId')
               ->setParameter('moduleId', $moduleId);
        }

        return $qb
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Compte le total d’interventions filtrées
     */
    public function countFiltered(
        ?\DateTimeInterface $start,
        ?\DateTimeInterface $end,
        ?int $moduleId
    ): int {
        $qb = $this->createQueryBuilder('i')
            ->select('COUNT(i.id)')
            ->leftJoin('i.module', 'm');

        if ($start) {
            $qb->andWhere('i.dateDebut >= :start')
               ->setParameter('start', $start);
        }

        if ($end) {
            $qb->andWhere('i.dateFin <= :end')
               ->setParameter('end', $end);
        }

        if ($moduleId) {
            $qb->andWhere('m.id = :moduleId')
               ->setParameter('moduleId', $moduleId);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
