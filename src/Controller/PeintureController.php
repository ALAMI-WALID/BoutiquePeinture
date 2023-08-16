<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeintureController extends AbstractController
{
    private $entityManager;

    private $megaMenu;
    public function __construct( MegaMenu $megaMenu)
    {

        $this->megaMenu = $megaMenu;

    }

    #[Route('/peinture', name: 'app_peinture')]
    public function index(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('peinture/index.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }
}
