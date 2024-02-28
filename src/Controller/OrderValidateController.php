<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Classe\MegaMenu;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OrderDetails;

class OrderValidateController extends AbstractController
{
    private $entityManager;
    private $megaMenu;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }


    #[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        
        if ($order->getState() == 0) {

            $order_detail = $this->entityManager->getRepository(OrderDetails::class)->findOneByMyorder($order->getId());

            //gestion de stock 
            foreach($cart->getFull() as $product) {    
                $product['product']->setStock($product['product']->getStock()-$order_detail->getQuantity());
                $this->entityManager->persist($product['product']);
            }

            // Vider la session "cart"
            $cart->remove();

    
            // Modifier le statut isPaid de notre commande en mettant 1
            $order->setState(1);
            $this->entityManager->flush();

            // Envoyer un email à notre client pour lui confirmer sa commande
            $mail = new Mail();
            $content = "<br/>Merci pour votre commande N°".$order->getReference()."<br/>";

            $mail->confirmationOrder($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande Peinture Auto Expert est bien validée.', $content);

        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


        return $this->render('order_validate/index.html.twig', [
            'order' => $order,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

        ]);

    }
}
