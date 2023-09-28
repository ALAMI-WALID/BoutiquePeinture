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
     * @return PaginationInterface
     */

     //chercher par code et par nom et la marque
    public function findWithSearchGlobal(Search $search) : PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
        ->select('p')
        ->andWhere('p.name LIKE :string OR p.subtitle LIKE :string OR p.articleCode LIKE :string')
        ->setParameter('string', '%' . $search->string . '%');

        return $this->paginator->paginate(
            $query,
            $search->page,
            12
        );

    }


    //Search with SousSous-category
    /**
     * @return PaginationInterface
     */

     public function findWithAllSSc(Search $search,int $id): PaginationInterface
     {
         $query = $this->createQueryBuilder('p')
         ->select('p')
         ->andWhere('p.SScategory = :id')
         ->setParameter('id', $id);
         return $this->paginator->paginate($query,$search->page,9);
     }
     //search form with SScategory
    /**
     * @return PaginationInterface
     */

     public function findWithSearchSSc(Search $search,int $id,$ignorePrice = false): PaginationInterface
     {
         $query = $this->createQueryBuilder('p')
         ->select('p')
         ->andWhere('p.SScategory = :id')
         ->setParameter('id', $id);

         if (!empty($search->string)) {
            $query = $query
                ->andWhere('p.name LIKE :string OR p.articleCode LIKE :string')
                ->setParameter('string', "%" . $search->string . "%");
        }

        if (!empty($search->marque)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->marque );
        }
        if (!empty($search->Matiere)) {
            $query = $query
                ->andWhere('p.matierePapier LIKE :matiere ')
                ->setParameter('matiere', $search->Matiere );
        }
        if (!empty($search->marqueabrasif)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->marqueabrasif );
        }
        if (!empty($search->epaisseur)) {
            $query = $query
                ->andWhere('p.epaisseurRuban LIKE :epaisseur ')
                ->setParameter('epaisseur', $search->epaisseur);
        }
        if (!empty($search->bransMasquage)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->bransMasquage );
        }
        if (!empty($search->qualitePapier)) {
            $query = $query
                ->andWhere('p.qualitePapier LIKE :qualite ')
                ->setParameter('qualite', $search->qualitePapier );
        }
        if (!empty($search->potbombe)) {
            $query = $query
                ->andWhere('p.name LIKE :potbombe ')
                ->setParameter('potbombe', $search->potbombe. "%" );
        }
        if (!empty($search->Grain)) {
            $query = $query
                ->andWhere('p.grain LIKE :grain ')
                ->setParameter('grain', $search->Grain );
        }
        if (!empty($search->Papiercale)) {
            $query = $query
                ->andWhere('p.dimensionCale LIKE :dimension ')
                ->setParameter('dimension', $search->Papiercale );
        }
        if (!empty($search->marquepestole)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->marquepestole );
        }
        if (!empty($search->Diluant)) {
            $query = $query
                ->andWhere('p.Diluant LIKE :diluant')
                ->setParameter('diluant', $search->Diluant );
        }
        if (!empty($search->colorsAppret)) {
            $query = $query
                ->andWhere('p.colorsAppret LIKE :colors')
                ->setParameter('colors', $search->colorsAppret );
        }
        if (!empty($search->dimensionpapier)) {
            $query = $query
                ->andWhere('p.DimensionPapierCacher  LIKE :dimension')
                ->setParameter('dimension', $search->dimensionpapier);
        }
        if (!empty($search->pack)) {
            $query = $query
                ->andWhere('p.PackVernisFiltre LIKE :pack ')
                ->setParameter('pack', $search->pack );
        }

        if (!empty($search->FiltreContenance)) {
            $query = $query
                ->andWhere('p.FiltreContenance LIKE :FiltreContenance ')
                ->setParameter('FiltreContenance', "%" . $search->FiltreContenance . "%");
        }
        if (!empty($search->dimensionFiltre)) {
            $query = $query
                ->andWhere('p.dimensionfiltreCabine LIKE :Filtre')
                ->setParameter('Filtre',$search->dimensionFiltre);
        }
        if (!empty($search->typefiltreCabine)) {
            $query = $query
                ->andWhere('p.typeFiltreCabine LIKE :Filtre')
                ->setParameter('Filtre',$search->typefiltreCabine);
        }
        if (!empty($search->TypeTuyau)) {
            $query = $query
                ->andWhere('p.typeTuyau LIKE :typetuyau')
                ->setParameter('typetuyau',$search->TypeTuyau);
        }
        if (!empty($search->raccordAir)) {
            $query = $query
                ->andWhere('p.raccordAir LIKE :raccord')
                ->setParameter('raccord',$search->raccordAir);
        }
        if (!empty($search->dimensiontuyau)) {
            $query = $query
                ->andWhere('p.DimensionTuyau LIKE :tuyau')
                ->setParameter('tuyau',$search->dimensiontuyau);
        }

    
        if (!empty($search->min) && $ignorePrice === false ) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->min * 100);
        }

        if (!empty($search->buses)) {
            $query = $query
                 ->select('p','b')
                 ->join('p.buses', 'b')
                ->andWhere('b.id IN (:busIds)') // Assuming 'b.id' is the ID property of the 'buses' entity
                ->setParameter('busIds', $search->buses);
        }
        if (!empty($search->Contenance)) {
            $query = $query
                 ->select('p','c')
                 ->join('p.Size_Gobelet', 'c')
                ->andWhere('c.id IN (:ConID)') // Assuming 'c.id' is the ID property of the 'Contenance' entity
                ->setParameter('ConID', $search->Contenance);
        }
        if (!empty($search->TypePeinture)) {
            $query = $query
                 ->select('p','pcfes')
                 ->join('p.FiltrePeinture', 'pcfes')
                ->andWhere('pcfes.id IN (:ConID)') // Assuming 'c.id' is the ID property of the 'Contenance' entity
                ->setParameter('ConID', $search->TypePeinture);
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
         return $this->paginator->paginate($query,$search->page,9);
     }


     //search form with Sous category
     /**
     * @return PaginationInterface
     */

     public function findWithSearchSc(Search $search,int $id,$ignorePrice = false): PaginationInterface
     {
         $query = $this->createQueryBuilder('p')
         ->select('p')
        // Assuming 'b' is the alias for your 'buses' relation
         ->andWhere('p.Scategory = :id')
         ->setParameter('id', $id);

         if (!empty($search->string)) {
            $query = $query
                ->andWhere('p.name LIKE :string OR p.articleCode LIKE :string')
                ->setParameter('string', "%" . $search->string . "%");
        }

        if (!empty($search->Matiere)) {
            $query = $query
                ->andWhere('p.matierePapier LIKE :matiere ')
                ->setParameter('matiere', $search->Matiere );
        }
        if (!empty($search->marque)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->marque );
        }
        if (!empty($search->marqueabrasif)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->marqueabrasif );
        }
        if (!empty($search->epaisseur)) {
            $query = $query
                ->andWhere('p.epaisseurRuban LIKE :epaisseur ')
                ->setParameter('epaisseur', $search->epaisseur);
        }
        if (!empty($search->bransMasquage)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->bransMasquage );
        }
        if (!empty($search->qualitePapier)) {
            $query = $query
                ->andWhere('p.qualitePapier LIKE :qualite ')
                ->setParameter('qualite', $search->qualitePapier );
        }
        if (!empty($search->potbombe)) {
            $query = $query
                ->andWhere('p.name LIKE :potbombe ')
                ->setParameter('potbombe', $search->potbombe. "%" );
        }
        if (!empty($search->Grain)) {
            $query = $query
                ->andWhere('p.grain LIKE :grain ')
                ->setParameter('grain', $search->Grain );
        }
        if (!empty($search->Papiercale)) {
            $query = $query
                ->andWhere('p.dimensionCale LIKE :dimension ')
                ->setParameter('dimension', $search->Papiercale );
        }
        if (!empty($search->marquepestole)) {
            $query = $query
                ->andWhere('p.subtitle LIKE :marque ')
                ->setParameter('marque', $search->marquepestole );
        }
        if (!empty($search->Diluant)) {
            $query = $query
                ->andWhere('p.Diluant LIKE :diluant')
                ->setParameter('diluant', $search->Diluant );
        }
        if (!empty($search->colorsAppret)) {
            $query = $query
                ->andWhere('p.colorsAppret LIKE :colors')
                ->setParameter('colors', $search->colorsAppret );
        }
        if (!empty($search->dimensionpapier)) {
            $query = $query
                ->andWhere('p.DimensionPapierCacher  LIKE :dimension')
                ->setParameter('dimension', $search->dimensionpapier);
        }
        if (!empty($search->pack)) {
            $query = $query
                ->andWhere('p.PackVernisFiltre LIKE :pack ')
                ->setParameter('pack', $search->pack );
        }

        if (!empty($search->FiltreContenance)) {
            $query = $query
                ->andWhere('p.FiltreContenance LIKE :FiltreContenance ')
                ->setParameter('FiltreContenance', "%" . $search->FiltreContenance . "%");
        }
        if (!empty($search->dimensionFiltre)) {
            $query = $query
                ->andWhere('p.dimensionfiltreCabine LIKE :Filtre')
                ->setParameter('Filtre',$search->dimensionFiltre);
        }
        if (!empty($search->typefiltreCabine)) {
            $query = $query
                ->andWhere('p.typeFiltreCabine LIKE :Filtre')
                ->setParameter('Filtre',$search->typefiltreCabine);
        }
        if (!empty($search->TypeTuyau)) {
            $query = $query
                ->andWhere('p.typeTuyau LIKE :typetuyau')
                ->setParameter('typetuyau',$search->TypeTuyau);
        }
        if (!empty($search->raccordAir)) {
            $query = $query
                ->andWhere('p.raccordAir LIKE :raccord')
                ->setParameter('raccord',$search->raccordAir);
        }
        if (!empty($search->dimensiontuyau)) {
            $query = $query
                ->andWhere('p.DimensionTuyau LIKE :tuyau')
                ->setParameter('tuyau',$search->dimensiontuyau);
        }
        if (!empty($search->Contenance)) {
            $query = $query
                 ->select('p','c')
                 ->join('p.Size_Gobelet', 'c')
                ->andWhere('c.id IN (:ConID)') // Assuming 'c.id' is the ID property of the 'Contenance' entity
                ->setParameter('ConID', $search->Contenance);
        }
        if (!empty($search->TypePeinture)) {
            $query = $query
                 ->select('p','pcfes')
                 ->join('p.FiltrePeinture', 'pcfes')
                ->andWhere('pcfes.id IN (:ConID)') // Assuming 'c.id' is the ID property of the 'Contenance' entity
                ->setParameter('ConID', $search->TypePeinture);
        }
    
        if (!empty($search->min) && $ignorePrice === false ) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $search->min * 100);
        }
        if (!empty($search->buses)) {
            $query = $query
                 ->select('p','b')
                 ->join('p.buses', 'b')
                ->andWhere('b.id IN (:busIds)') // Assuming 'b.id' is the ID property of the 'buses' entity
                ->setParameter('busIds', $search->buses);
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
         return $this->paginator->paginate($query,$search->page,9);
     }

     //search with Sous Category
     /**
     * @return PaginationInterface
     */
     public function findWithAllSc(Search $search,int $id): PaginationInterface
     {
         $query = $this->createQueryBuilder('p')
         ->select('p')
         ->andWhere('p.Scategory = :id')
         ->setParameter('id', $id);
         return $this->paginator->paginate($query,$search->page,9);
     }

    //search with brands
     /**
     * @return PaginationInterface
     */
     public function findWithBrand(Search $search,string $brand): PaginationInterface
     {
         $query = $this->createQueryBuilder('p')
         ->select('p')
         ->andWhere('p.subtitle = :brand')
         ->setParameter('brand', $brand);
         return $this->paginator->paginate($query,$search->page,9);
     }


     private function getAllQuery($ignorePrice = false): QueryBuilder
     {
         $query = $this->createQueryBuilder('p')
             ->select('p');
         // You can add more conditions to your query here if needed
         // Example: $query->where('p.someColumn = :someValue');
 
         return $query;
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
        ->select('p');

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
