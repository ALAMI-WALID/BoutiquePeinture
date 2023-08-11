<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator )
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
  
    /**
     * @return PaginationInterface
     */
    public function findWithSearch(Search $search) : PaginationInterface
    {
    
       
        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );

    }

      /**
     * @return integer[]
     */
    public function findMinMax(Search $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.price) as min', 'MAX(p.price) as max')
            ->getQuery()
            ->getScalarResult();
            $min = (int)($results[0]['min'] / 100);
             $max = (int)($results[0]['max'] / 100);

    return [$min, $max];
    }


    private function getSearchQuery(Search $search , $ignorePrice = false):QueryBuilder
    {
        $query = $this
        ->createQueryBuilder('p')
        ->select('c', 'p')
        ->join('p.category', 'c');

    if (!empty($search->categories)) {
        $query = $query
            ->andWhere('c.id IN (:categories)')
            ->setParameter('categories', $search->categories);
    }

    if (!empty($search->string)) {
        $query = $query
            ->andWhere('p.name LIKE :string OR p.articleCode LIKE :string')
            ->setParameter('string', "%{$search->string}%");
    }

    if (!empty($search->min) && $ignorePrice === false ) {
        $query = $query
            ->andWhere('p.price >= :min')
            ->setParameter('min', $search->min * 100);
    }

    if (!empty($search->max) && $ignorePrice === false ) {
        $query = $query
            ->andWhere('p.price <= :max')
            ->setParameter('max', $search->max * 100);
    }
    if (!empty($search->promo)) {
        $query = $query
            ->andWhere('p.promo = 1');
    }

    return $query;
    }


//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
