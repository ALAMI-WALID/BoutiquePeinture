<?php

namespace App\Controller;

use App\Entity\BaseOfficielleDesCodesPostaux;
use App\Entity\Carrier;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;

class OrderController extends AbstractController
{   
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/commande', name: 'order')]
    public function index( Cart $cart, Request $request ): Response
    {

        if(!$this->getUser()->getAddresses()->getValues()){
           return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getfull(),
        ]);
    }

    #[Route('/commande/recapitulatif', name: 'order_recap', methods:"POST")]
    public function add( Cart $cart, Request $request ): Response
    {

        if(!$this->getUser()->getAddresses()->getValues()){
           return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        //recapitulatif de ma commande 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable('now');
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .= '<br/>'.$delivery->getPhone();

            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>'.$delivery->getCompany();
            }

            $delivery_content .= '<br/>'.$delivery->getAddress();
            $delivery_content .= '<br/>'.$delivery->getPostal().' '.$delivery->getCity();
            $delivery_content .= '<br/>'.$delivery->getCountry();

            //vérification de livraison hors ile-de-france
            $codesPostauxIleDeFrance = $this->entityManager->getRepository(BaseOfficielleDesCodesPostaux::class)->findByCode($delivery->getPostal());
            if (!$codesPostauxIleDeFrance) {
              
                foreach($cart->getFull() as $product){

                    if(!$product['product']->getLivrableHorsIleDeFrance()){


                        return $this->render('order/nonlivraison.html.twig'); 
                    }
                }
            }
        //enregistre ma commande sur Order:
        $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);


            

        $this->entityManager->persist($order);

            

            // Enregistrer mes produits OrderDetails()
            foreach($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
            
        }

            $this->entityManager->flush();

        return $this->render('order/add.html.twig',[
            'cart' => $cart->getFull(),
            'carrier' => $carriers,
            'delivery' => $delivery_content,
            'reference' => $order->getReference()

        ]);
    }  else{
        return $this->redirectToRoute('cart');}

    }
}
