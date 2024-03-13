<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{

    private $megaMenu;

    public function __construct( MegaMenu $megaMenu)
    {
        
        $this->megaMenu = $megaMenu;

    }
    #[Route('/favoris', name: 'favoris')]
    public function index(): Response
    {

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('favoris/index.html.twig', [
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }
}
