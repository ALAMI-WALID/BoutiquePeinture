<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\MegaMenu;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class SearchDataController extends AbstractController
{

    private $entityManager;
    private $megaMenu;

    
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }

    #[Route('/search/data', name: 'app_search_data')]
    public function index(Request $request): Response
    {

        if ($request->isMethod('GET')) {

            $searchQuery = $request->query->get('q');
            $products = $this->entityManager->getRepository(Product::class)->findBySearchData($searchQuery);


            $categories = $this->megaMenu->mega();
            $Scategories = $this->megaMenu->megaS();
            $SScategories = $this->megaMenu->megaSS();
         
            
        } 
        return $this->render('home/search.html.twig',[
               
            'products' => $products,
            'categories' =>$categories,
            'Scategories' => $Scategories,
            'SScategories'=>$SScategories
        ]);
    }
}




