<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Search;
use App\Form\SearchGlobalType;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Header;

class HomeController extends AbstractController
{
    private $entityManager;
    private $megaMenu;

    
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }


  

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {


        
        $search = new Search();
        $form = $this->createForm(SearchGlobalType::class, $search);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);


            $categories = $this->megaMenu->mega();
            $Scategories = $this->megaMenu->megaS();
            $SScategories = $this->megaMenu->megaSS();
            if (empty($products)) {
                
                
                return $this->render('home/search.html.twig', [
                    'products' => [],
                    'form' => $form->createView(),
                    'categories' =>$categories,
                    'Scategories' => $Scategories,
                    'SScategories'=>$SScategories
                ]);
            }
            return $this->render('home/search.html.twig',[
               
                'products' => $products,
                'form' => $form->createView(),
                'categories' =>$categories,
                'Scategories' => $Scategories,
                'SScategories'=>$SScategories
    
            ]);
        } 
       else{

        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


        

        return $this->render('home/index.html.twig',[
            'products' => $products,
            'headers' => $headers,
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories


        ]);
    }
    }
}
