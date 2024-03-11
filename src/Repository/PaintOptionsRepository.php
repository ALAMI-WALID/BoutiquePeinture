<?php

namespace App\Repository;

use App\Entity\PaintOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaintOptions>
 *
 * @method PaintOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaintOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaintOptions[]    findAll()
 * @method PaintOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaintOptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaintOptions::class);
    }

//    /**
//     * @return PaintOptions[] Returns an array of PaintOptions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PaintOptions
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
