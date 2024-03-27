<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $megaMenu;

    public function __construct( MegaMenu $megaMenu)
    {
        
        $this->megaMenu = $megaMenu;

    }
    #[Route('/nous-contact', name: 'contact', options: ['sitemap'=> ['section' =>'contact']])]
    public function index(Request $request): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais.');
        }

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('contact/index.html.twig',[
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories


        ]);
    }
}
