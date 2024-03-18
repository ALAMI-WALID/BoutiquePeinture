<?php

namespace App\Repository;

use App\Entity\SearchTeinte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SearchTeinte>
 *
 * @method SearchTeinte|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchTeinte|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchTeinte[]    findAll()
 * @method SearchTeinte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchTeinteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchTeinte::class);
    }

//    /**
//     * @return SearchTeinte[] Returns an array of SearchTeinte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SearchTeinte
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
