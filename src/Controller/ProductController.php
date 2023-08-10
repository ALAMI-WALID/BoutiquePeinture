<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Search;
use App\Entity\Product;
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
        $minPrice = 0;
        $maxPrice = 5000;

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $intervallePrix = $form->get('priceRange')->getData();
            [$minPrice, $maxPrice] = explode(',', $intervallePrix);
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);

        } else {
            $products = $this->entityManager->getRepository(Product::class)->findAll();
        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();



        return $this->render('product/index.html.twig', [
        
            'products' => $products,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'form' => $form->createView(),
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
}
