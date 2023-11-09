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
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class ProductController extends AbstractController
{   
    private $entityManager;

    private $megaMenu;

    private $breadcrumbs;

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
    public function ShowCategory(Request $request,$id,Breadcrumbs $breadcrumbs): Response
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
        $showDimensionPapeir=false;
        $showContenance=false;
        $showColorsAppret=false;
        $showraccordAir=false;
        $showDimensimTuyau=false;
        $showrdimensionFiltre=false;
        $showvernis=false;
      

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

         if(in_array($idScategory->getId(),[2,3])){
            $showvernis= true;
         }


         if($sscategory->getId() == 17){
            $showFiltreDiluant=true;
         }
         if(in_array($idScategory->getId(),[5,])){
            $showbrandspestole=true;
         }
         if($idScategory->getId() == 6){
            $showPotbombe =true;
         }
         if(in_Array($idScategory->getId(), [7,9,10,11,13,16,17,20,29])){
            $showbrandsAbrasif=true;
         }

         if(in_array($sscategory->getId(), [34,35,36,37,128])){
            $showGrain=true;
         }

         if(in_array($sscategory->getId(),[60,36])){
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

        if($sscategory->getId() == 46){
            $showDimensionPapeir=true;
        } 

        if(in_array($idScategory->getId(),[3,4,10,11]) || in_array($sscategory->getId(),[72])){
            $showContenance=true;
           
         }

         if(in_array($idScategory->getId(),[10,11])){
            $showColorsAppret=true;
         }
         if($sscategory->getId()==109){
            $showraccordAir=true;

         }
         if($sscategory->getId()==110){

             $showDimensimTuyau=true;
         }
         if($sscategory->getId()==113){

            $showrdimensionFiltre=true;
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
            'showDimensionPapeir'=>$showDimensionPapeir,
            'showContenance'=>$showContenance,
            'showColorsAppret'=>$showColorsAppret,
            'showraccordAir'=>$showraccordAir,
            'showDimensimTuyau'=>$showDimensimTuyau,
            'showrdimensionFiltre'=>$showrdimensionFiltre,
            'showvernis'=>$showvernis,
           
   

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


        //fil d'ariane 
        $scategory= $SScategory[0]->getIdSousCategory();
        $Scategory = $this->entityManager->getRepository(SousCategory::class)->findByid($scategory);
        $titre_category =  $Scategory[0]->getCategoryID()->getName();



        $breadcrumbs->addItem("Accueil", $this->generateUrl("app_home"));
        $breadcrumbs->addItem($titre_category, $this->generateUrl("productsInSCategory",['id' => $scategory->getId()]));
        $breadcrumbs->addItem( $Scategory[0]->getName(), $this->generateUrl("productsInSCategory",['id' => $scategory->getId()]));
        $breadcrumbs->addItem( $SScategory[0]->getName(), $this->generateUrl("productsInCategory",['id' => $id]));





        
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        

        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            "breadcrumbs" => $breadcrumbs,
            'titre_category'=>$titre_category,
            'min'=>$min,
            'max'=>$max,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

        ]);
    }


    #[Route('/nos_categorais/{id}', name: 'productsInSCategory')]
    public function ShowSCategory(Request $request,$id,Breadcrumbs $breadcrumbs): Response
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
        $showDimensionPapeir=false;
        $showContenance=false;
        $showColorsAppret=false;
        $showraccordAir=false;
        $showDimensimTuyau=false;
        $showrdimensionFiltre=false;
        $showvernis=false;

        $search = new Search();
        $search->page = $request->get('page', 1);

        //recherche par le nom pour affiche le filtre dans le Scategory Vernis.
        $Scategory = $this->entityManager->getRepository(SousCategory::class)->findByid($id);

        foreach($Scategory as $scategory){
        
        //Condition de filtre selon les Sous category.
        if(in_array($scategory->getId(), [1])){
            $showFiltrepeinture = true;
            $showContenanceFilter=true;

        }
        if(in_array($scategory->getId(), [2,3])){
            $showFiltrebrands=true;
            $showvernis=true;
        }

        if(in_array($scategory->getId(), [4])){
            $showFiltrebrands=true;
            $showFiltreDiluant=true;
           
        }
        if(in_array($scategory->getId(), [5])){
            $showbrandspestole=true;
            $showBusFilter=true;
           
        }
        if(in_array($scategory->getId(), [6])){
            $showPotbombe=true;
           
        }
        if(in_array($scategory->getId(), [7])){
            $showbrandsAbrasif=true;
            $showGrain=true;
            $showPapiercale=true;
            $showMatiereCale=true;
            $showQalitePapier=true;
        }
        if(in_array($scategory->getId(), [8])){
           $showbrandMasquage=true;
           $showepaisseur=true;
        }

        if(in_array($scategory->getId(), [9])){
            $showbrandsAbrasif=true;
            $showMatiereCale=true;
         }
         if(in_array($scategory->getId(), [10,11])){
          $showbrandsAbrasif=true;
          $showColorsAppret=true;
          $showContenance=true;
          
         }
         if(in_array($scategory->getId(), [13])){
            $showbrandsAbrasif=true;
            $showContenance=true;
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
            'showDimensionPapeir'=>$showDimensionPapeir,
            'showContenance'=>$showContenance,
            'showColorsAppret'=>$showColorsAppret,
            'showraccordAir'=>$showraccordAir,
            'showDimensimTuyau'=>$showDimensimTuyau,
            'showrdimensionFiltre'=>$showrdimensionFiltre,
            'showvernis'=>$showvernis,
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

        
        //fil d'ariane
        $titre_category =  $Scategory[0]->getCategoryID()->getName();
        $breadcrumbs->addItem("Accueil", $this->generateUrl("app_home"));
        $breadcrumbs->addItem(  $titre_category, $this->generateUrl("productsInSCategory",['id' => $id]));
        $breadcrumbs->addItem( $Scategory[0]->getName(), $this->generateUrl("productsInSCategory",['id' => $id]));





        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'min'=>$min,
            'max'=>$max,
            'titre_category'=> $titre_category,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            "breadcrumbs" => $breadcrumbs,
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
    public function ShowBrands(Request $request,$brand,Breadcrumbs $breadcrumbs): Response
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

        //fil d'ariane 
        $breadcrumbs->addItem("Accueil", $this->generateUrl("app_home"));
        $breadcrumbs->addItem( $brand, $this->generateUrl("productsInBrand",['brand' => $brand]));
        

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'min'=>$min,
            'max'=>$max,
            "breadcrumbs" => $breadcrumbs,
            'titre_category'=>$brand,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }
}
