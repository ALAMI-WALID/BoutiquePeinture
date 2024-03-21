<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AccountOrderController extends AbstractController
{
    private $entityManager;

    private $megaMenu;

    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }

    #[Route('/compte/mes-commandes', name: 'account_order', methods:['GET' | 'POST'])]
    public function index(Request $request): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        //Reponse Ajax
        $orderId =null;
        if ($request->isMethod('POST')) {
            $orderId = $request->request->get('orderId');
            if ($orderId != null) {
                $orderResult = $this->entityManager->getRepository(Order::class)->findById($orderId);
                //j'ai met 0 car toujour ordeResult  est un seul tableau.
                $orderResult[0]->setProvided(1);
                $this->entityManager->flush();
            }
            return new Response();
        }
        return $this->render('account/order.html.twig', [
            'orders' => $orders,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

        ]);
    }
    

    #[Route('/compte/mes-commandes/{reference}', name: 'account_order_show')]
    public function show($reference)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }
}
