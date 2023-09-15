<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Search;
use App\Entity\Product;
use App\Entity\SousCategory;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\SousSousCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{   
    private $entityManager;

    private $megaMenu;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }

    #[Route('/nos_produits', name: 'products')]
    public function index(Request $request): Response
    {   

        $search = new Search();
        $search->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        [$min,$max] = $this->entityManager->getRepository(Product::class)->findMinMax($search);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {

            $products = $this->entityManager->getRepository(Product::class)->findWithAll($search);
        }
        
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'min'=>$min,
            'max'=>$max,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }

    #[Route('/nos_produits/{id}', name: 'productsInCategory')]
    public function ShowCategory(Request $request,$id): Response
    {   
        $showBusFilter = false;
        $showContenanceFilter = false;
        $showFiltrepeinture = false;
        $showFiltrebrands= false;
        $showFiltreDiluant=false;
        $showbrandspestole=false;
        $showPotbombe =false;
        $showbrandsAbrasif=false;
        $showGrain=false;
        $showPapiercale=false;
        $showMatiereCale=false;
        $showQalitePapier=false;
        $showbrandMasquage=false;
        $showepaisseur=false;

        $search = new Search();
        $search->page = $request->get('page', 1);
         //recherche par le nom pour affiche le filtre dans le Scategory Vernis
         $SScategory = $this->entityManager->getRepository(SousSousCategory::class)->findByid($id);

         

         foreach($SScategory as $sscategory){
             $idScategory= $sscategory->getIdSousCategory();
             //Condition de filtre selon les SousSous category
         if(in_array($sscategory->getId(), [126,127])){
             $showBusFilter = true;
         }
         if($sscategory->getId() == 1){
            $showContenanceFilter = true;
         }

         if($sscategory->getid() == 3 ){
            $showFiltrepeinture = true;
         }

         if(in_array($sscategory->getId(), [6,7, 8,9]) || in_array($idScategory->getId(),[3,4])){
            $showFiltrebrands= true;
         }
         if($sscategory->getId() == 17){
            $showFiltreDiluant=true;
         }
         if(in_array($idScategory->getId(),[5])){
            $showbrandspestole=true;
         }
         if($idScategory->getId() == 6){
            $showPotbombe =true;
         }
         if($idScategory->getId() == 7){
            $showbrandsAbrasif=true;
         }

         if(in_array($sscategory->getId(), [34,35,36,37,128])){
            $showGrain=true;
         }

         if($sscategory->getId() == 36){
            $showPapiercale=true;
        }
        
        if($sscategory->getId() == 128){
            $showMatiereCale = true;
        }

       
        if(in_array($sscategory->getId(), [34,35,36])){
            $showQalitePapier=true;
        }

        if($idScategory->getId() == 8){
            $showbrandMasquage=true;
        }

        if($sscategory->getId() == 42){
            $showepaisseur=true;
        }


       

       
         }



         $form = $this->createForm(SearchType::class, $search,[
            'showBusFilter' => $showBusFilter,
            'showContenanceFilter'=>$showContenanceFilter,
            'showFiltrepeinture'=>$showFiltrepeinture,
            'showFiltrebrands'=>$showFiltrebrands,
            'showFiltreDiluant'=>$showFiltreDiluant,
            'showbrandspestole'=>$showbrandspestole,
            'showPotbombe'=>$showPotbombe,
            'showbrandsAbrasif'=>$showbrandsAbrasif,
            'showGrain'=>$showGrain,
            'showPapiercale'=>$showPapiercale,
            'showMatiereCale'=>$showMatiereCale,
            'showQalitePapier'=>$showQalitePapier,
            'showbrandMasquage'=>$showbrandMasquage,
            'showepaisseur'=>$showepaisseur,
   

        ]);
        $form->handleRequest($request);

 


        [$min,$max] = $this->entityManager->getRepository(Product::class)->findMinMax($search);
        if ($form->isSubmitted() && $form->isValid()) {

            //j'ai besoin de passe la liste selon les categorise
            $products = $this->entityManager->getRepository(Product::class)->findWithSearchSSc($search,$id);
        } else {

            //search with Sous S category
            $products = $this->entityManager->getRepository(Product::class)->findWithAllSSc($search, $id);
        }
        
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        

        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'min'=>$min,
            'max'=>$max,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }


    #[Route('/nos_categorais/{id}', name: 'productsInSCategory')]
    public function ShowSCategory(Request $request,$id): Response
    {   
        $showBusFilter = false;
        $search = new Search();
        $search->page = $request->get('page', 1);

        //recherche par le nom pour affiche le filtre dans le Scategory Vernis
        $Scategory = $this->entityManager->getRepository(SousCategory::class)->findByid($id);
        foreach($Scategory as $name){
        if($name->getName() === 'Vernis'){
            $showBusFilter = true;
        }
        }

        $form = $this->createForm(SearchType::class, $search,[
            'showBusFilter' => $showBusFilter,
        ]);
        $form->handleRequest($request);

        // if ( $form->getClickedButton() && 'reset' === $form->getClickedButton()->getName()) {
        //     // The "Réinitialiser" button was clicked, reset the filters
        //     $search = new Search();
        //     $search->page = $request->get('page', 1);
        //     $form = $this->createForm(SearchType::class, $search);
        // }

        [$min,$max] = $this->entityManager->getRepository(Product::class)->findMinMax($search);
        if ($form->isSubmitted() && $form->isValid()) {

        $products = $this->entityManager->getRepository(Product::class)->findWithSearchSc($search,$id);

        } else {
            //search with Sous S category
            $products = $this->entityManager->getRepository(Product::class)->findWithAllSc($search, $id);
        }
        
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'min'=>$min,
            'max'=>$max,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }


    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug): Response
    {   

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);



        if(!$product){
            return $this->redirectToRoute('products');
        }

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


        return $this->render('product/show.html.twig', [
        
            'product' => $product,
            'products' => $products,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

        ]);
    }

    #[Route('/nos_marques/{brand}', name: 'productsInBrand')]
    public function ShowBrands(Request $request,$brand): Response
    {   

        $search = new Search();
        $search->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        [$min,$max] = $this->entityManager->getRepository(Product::class)->findMinMax($search);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findWithBrand($search, $brand);
        }
        
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'min'=>$min,
            'max'=>$max,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }
}
