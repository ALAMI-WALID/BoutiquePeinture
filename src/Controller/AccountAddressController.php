<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;

class AccountAddressController extends AbstractController
{
    private $entityManager;
    private $megaMenu;

    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }
    #[Route('/compte/adresses', name: 'account_address')]
    public function index(): Response
    {

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('account/address.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
            
        ]);
    }

    #[Route('/compte/ajouter-une-adresse', name: 'account_address_add')]
    public function add(Request $request, SessionInterface $session, Cart $cart): Response
    { 
        $address = new Address;
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
           $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            if($cart->get()){
                return $this->redirectToRoute('order');
            }else
            {
                
                $session->getFlashBag()->add('success', 'Votre nouvelle adresse a été ajoutée avec succès !');
                return $this->redirectToRoute('account_address');
            }

        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('account/address_form.html.twig',[
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

            
        ]);
    }

    #[Route('/compte/modifier-une-adresse/{id}', name: 'account_address_edit')]
    public function edit(Request $request, SessionInterface $session, $id): Response
    { 
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        
        if( !$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');

        }
        $form = $this->createForm(AddressType::class, $address);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
           $address->setUser($this->getUser());
            $this->entityManager->flush();
            $session->getFlashBag()->add('success', 'Votre nouvelle adresse a été ajoutée avec succès !');
            return $this->redirectToRoute('account_address');

        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('account/address_form.html.twig',[
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' => $Scategories,
            'SScategories'=>$SScategories

            
        ]);
    }

    #[Route('/compte/supprime-une-adresse/{id}', name: 'account_address_delete')]
    public function remove(SessionInterface $session, $id): Response
    { 
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);
        
        if( $address && $address->getUser() == $this->getUser()){
            $this->entityManager->remove($address);
            $this->entityManager->flush();

        }
            
        
        return $this->redirectToRoute('account_address');
    }
    
}
