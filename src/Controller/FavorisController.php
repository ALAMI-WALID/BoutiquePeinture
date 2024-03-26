<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Favoris;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{

    private $megaMenu;

    private $entityManager;




    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;


    }
  
    #[Route('/favoris', name: 'favoris')]
    public function index(Request $request, Favoris $favoris): Response
    {

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('favoris/index.html.twig', [
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories,
            'favoris' => $favoris->getfull(),
        ]);
    }

    #[Route('/favoris/delete/{id}', name: 'delete_my_product')]
    public function delete(Favoris $favoris, $id): Response
    {
        $favoris->delete($id);

        return $this->redirectToRoute('favoris');
    }
}
