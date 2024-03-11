<?php

namespace App\Repository;

use App\Entity\PaintEstimations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaintEstimations>
 *
 * @method PaintEstimations|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaintEstimations|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaintEstimations[]    findAll()
 * @method PaintEstimations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaintEstimationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaintEstimations::class);
    }

//    /**
//     * @return PaintEstimations[] Returns an array of PaintEstimations objects
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

   public function findByCarType($value)
   {
       return $this->createQueryBuilder('pe')
           ->andWhere('pe.car_type = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult()
       ;
   }

   


}
