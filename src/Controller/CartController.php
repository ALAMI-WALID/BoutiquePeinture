<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\MegaMenu;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;
    private $megaMenu;

    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }
    #[Route('/mon_panier', name: 'cart', options: ['sitemap'=> ['section' =>'Mon_panier']])]
    public function index(Cart $cart): Response
    {    

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();



        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getfull(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories



        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id)
    { 

        //gestion de stock
        foreach($cart->getFull() as $product) {  
            
            if(($product['quantity'] >= ($product['product']->getStock()))){
                $cart->decrease($id);
                return $this->redirectToRoute('cart');
            }
           
        }

            
        $cart->add($id);
           
       

        return $this->redirectToRoute('cart');

    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('products');
    }

    #[Route('/cart/delete/{id}', name: 'delete_my_product')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }
    #[Route('/cart/decrease/{id}', name: 'decrease_my_product')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }
}
