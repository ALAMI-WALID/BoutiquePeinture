<?php

namespace App\Repository;

use App\Entity\BaseOfficielleDesCodesPostaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BaseOfficielleDesCodesPostaux>
 *
 * @method BaseOfficielleDesCodesPostaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseOfficielleDesCodesPostaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseOfficielleDesCodesPostaux[]    findAll()
 * @method BaseOfficielleDesCodesPostaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseOfficielleDesCodesPostauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseOfficielleDesCodesPostaux::class);
    }

    public function save(BaseOfficielleDesCodesPostaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BaseOfficielleDesCodesPostaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return BaseOfficielleDesCodesPostaux[] Returns an array of BaseOfficielleDesCodesPostaux objects
    */
   public function findByCode($value): array
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.Code_postale = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?BaseOfficielleDesCodesPostaux
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
