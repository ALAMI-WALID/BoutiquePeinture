<?php

namespace App\Repository;

use App\Entity\CodePeinture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CodePeinture>
 *
 * @method CodePeinture|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePeinture|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePeinture[]    findAll()
 * @method CodePeinture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodePeintureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodePeinture::class);
    }

    public function save(CodePeinture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CodePeinture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function FindByMarque()
    {
        $query = $this
        ->createQueryBuilder('c')
        ->select('DISTINCT c.Hersteller')
        ->orderBy('c.Hersteller', 'ASC');
        
        return $query->getQuery()->getResult();


    }
//Search with brand
    public function findByHersteller($value){
        return $this->createQueryBuilder('c')
            ->select('c')
           ->andWhere('c.Hersteller = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult()
       ; 

    }
//    /**
//     * @return CodePeinture[] Returns an array of CodePeinture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CodePeinture
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
