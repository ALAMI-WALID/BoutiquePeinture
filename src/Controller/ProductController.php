<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Search;
use App\Entity\PotBD;
use App\Entity\Product;
use App\Form\PotDBType;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
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
        // if ($form->isSubmitted() && $form->isValid()) {
        [$min,$max] = $this->entityManager->getRepository(Product::class)->findMinMax($search);

        
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);


        // } else {
        //     $products = $this->entityManager->getRepository(Product::class)->findAll();
        // }
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

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Product::class)->findBy(['SScategory' => $id]);

        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();



        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }

    #[Route('/produit/{slug}', name: 'product')]
    public function show($slug, Request $request): Response
    {   

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);


        if(!$product){
            return $this->redirectToRoute('products');
        }
        

        $form = $this->createForm(PotDBType::class);

        $form->handleRequest($request);

    
        //la forme de pot qui va search les prix dans la table potbd        
        if ($form->isSubmitted() && $form->isValid()) {

            $potQ = $form->get('potQ')->getData();
            $potbdprice= $potQ->getPriceBd();
            $product->setPrice($potbdprice);
            
            $this->entityManager->flush();

        } else {
            $potbdprice= $product->getPrice();
        }

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();



        return $this->render('product/show.html.twig', [
        
            'product' => $product,
            'products' => $products,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories,
            'potbd'=>$potbdprice,
            'form' => $form->createView()


        ]);
    }

   
}
