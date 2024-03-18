<?php

namespace App\Repository;

use App\Entity\MarqueTeinte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MarqueTeinte>
 *
 * @method MarqueTeinte|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarqueTeinte|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarqueTeinte[]    findAll()
 * @method MarqueTeinte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueTeinteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarqueTeinte::class);
    }

//    /**
//     * @return MarqueTeinte[] Returns an array of MarqueTeinte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MarqueTeinte
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
