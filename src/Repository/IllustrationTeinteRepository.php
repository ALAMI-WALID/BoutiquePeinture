<?php

namespace App\Repository;

use App\Entity\IllustrationTeinte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IllustrationTeinte>
 *
 * @method IllustrationTeinte|null find($id, $lockMode = null, $lockVersion = null)
 * @method IllustrationTeinte|null findOneBy(array $criteria, array $orderBy = null)
 * @method IllustrationTeinte[]    findAll()
 * @method IllustrationTeinte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IllustrationTeinteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IllustrationTeinte::class);
    }

//    /**
//     * @return IllustrationTeinte[] Returns an array of IllustrationTeinte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IllustrationTeinte
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
