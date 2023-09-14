<?php

namespace App\Repository;

use App\Entity\PCFES;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PCFES>
 *
 * @method PCFES|null find($id, $lockMode = null, $lockVersion = null)
 * @method PCFES|null findOneBy(array $criteria, array $orderBy = null)
 * @method PCFES[]    findAll()
 * @method PCFES[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PCFESRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PCFES::class);
    }

//    /**
//     * @return PCFES[] Returns an array of PCFES objects
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

//    public function findOneBySomeField($value): ?PCFES
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
