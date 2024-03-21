<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Entity\BaseOfficielleDesCodesPostaux;
use App\Entity\Carrier;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\ShippingRate;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;
use App\Entity\Product;

class OrderController extends AbstractController
{   
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

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

        $carrier = $this->entityManager->getRepository(Carrier::class)->findById(1);


        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getfull(),
            'carrier'=>$carrier,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

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
            $deliveryb= $form->get('addressess')->getData();
            $delivery = $form->get('addresses')->getData();

            //add de addresse de livraison
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .= '<br/>'.$delivery->getPhone();
            if ($delivery->getCompany()) {
                $delivery_content .= '<br/>'.$delivery->getCompany();
            }
            $delivery_content .= '<br/>'.$delivery->getAddress();
            $delivery_content .= '<br/>'.$delivery->getPostal().' '.$delivery->getCity();
            $delivery_content .= '<br/>'.$delivery->getCountry();

            //add de addresse de facturation
            $delivery_content_b = $deliveryb->getFirstname().' '.$deliveryb->getLastname();
            $delivery_content_b .= '<br/>'.$deliveryb->getPhone();
            if ($deliveryb->getCompany()) {
                $delivery_content_b .= '<br/>'.$deliveryb->getCompany();
            }
            $delivery_content_b .= '<br/>'.$deliveryb->getAddress();
            $delivery_content_b .= '<br/>'.$deliveryb->getPostal().' '.$delivery->getCity();
            $delivery_content_b .= '<br/>'.$deliveryb->getCountry();

           

            

            //vérification de livraison hors ile-de-france
            $codesPostauxIleDeFrance = $this->entityManager->getRepository(BaseOfficielleDesCodesPostaux::class)->findByCode($delivery->getPostal());
            if (!$codesPostauxIleDeFrance) {
              
                foreach($cart->getFull() as $product){

                    if(!$product['product']->getLivrableHorsIleDeFrance()){
                        $categories = $this->megaMenu->mega();
                        $Scategories = $this->megaMenu->megaS();
                        $SScategories = $this->megaMenu->megaSS();


                        return $this->render('order/nonlivraison.html.twig',[
                            'categories' =>$categories,
                            'Scategories' =>$Scategories,
                            'SScategories'=>$SScategories
                        ]); 
                    }
                }
            }


            $totalWeight=0;
            $totalShipping = null;
            
    
            //Calcule le poids de colis corresponde les tarifs de livraison.
            foreach($cart->getFull() as $product) {
                $totalWeight += ($product['product']->getweight()*$product['quantity']);
                
            }
            $shippingRates = $this->entityManager->getRepository(ShippingRate::class)->findAll();
            // $carrier = $this->entityManager->getRepository(Carrier::class)->findOneBy(['id' => 1]);  // Replace 1 with the ID of your carrier
    
            foreach($shippingRates as $rate) {
                if ($totalWeight >= $rate->getStartWeight() && $totalWeight < $rate->getEndWeight()) {
                    $totalShipping = $rate->getRate();
                    
                    break;
                    
                }
                else {
                    $totalShipping = 0;
                }
            }
    
        //enregistre ma commande sur Order:
        $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($totalShipping);
            $order->setDelivery($delivery_content);
            $order->setDeliveryBilling($delivery_content_b);
            $order->setState(0);
            $order->setProvided(0);


            

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
            $categories = $this->megaMenu->mega();
            $Scategories = $this->megaMenu->megaS();
            $SScategories = $this->megaMenu->megaSS();



        return $this->render('order/add.html.twig',[
            'cart' => $cart->getFull(),
            'carrier' => $carriers,
            'delivery' => $delivery_content,
            'deliveryb' => $delivery_content_b,
            'reference' => $order->getReference(),
            'totalShipping'=>$totalShipping,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories




        ]);
    }  else{
        return $this->redirectToRoute('cart');}

    }
}
