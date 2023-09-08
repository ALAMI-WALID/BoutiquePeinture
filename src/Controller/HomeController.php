<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Search;
use App\Entity\CodePeinture;
use App\Form\CodePeintureType;
use App\Form\SearchGlobalType;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Header;

class HomeController extends AbstractController
{
    private $entityManager;
    private $megaMenu;

    
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }


  

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {


        
        $search = new Search();
        $form = $this->createForm(SearchGlobalType::class, $search);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);


            $categories = $this->megaMenu->mega();
            $Scategories = $this->megaMenu->megaS();
            $SScategories = $this->megaMenu->megaSS();
            if (empty($products)) {
                
                
                return $this->render('home/search.html.twig', [
                    'products' => [],
                    'form' => $form->createView(),
                    'categories' =>$categories,
                    'Scategories' => $Scategories,
                    'SScategories'=>$SScategories
                ]);
            }
            return $this->render('home/search.html.twig',[
               
                'products' => $products,
                'form' => $form->createView(),
                'categories' =>$categories,
                'Scategories' => $Scategories,
                'SScategories'=>$SScategories
    
            ]);
        } 
       else{

        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();

        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


        

        return $this->render('home/index.html.twig',[
            'products' => $products,
            'headers' => $headers,
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories


        ]);
    }
    }

    #[Route('Condition_generals', name: 'CGV')]
    public function condition(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/condition.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }

    #[Route('Mention_legales', name: 'MLS')]
    public function legal(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/mention_legale.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }

    #[Route('paiement_securisé', name: 'PS')]
    public function paiement(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/paiement_securise.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }

    #[Route('RGPD', name: 'RGPD')]
    public function RGPD(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/Rgpd.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }
    #[Route('Installation_de_labo', name: 'labo')]
    public function labo(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/labo.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }

    #[Route('Compte_professionnel', name: 'pro')]
    public function pro(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/pro.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }
    #[Route('code_peinture', name: 'CodeP')]
    public function CodeP(Request $request): Response
    {
        //récupere les données sans doublon
        $marques = $this->entityManager->getRepository(CodePeinture::class)->FindByMarque();
        $brands=[];
        //stock les marque dans un tab
        foreach($marques as $marque){
            if (isset($marque["Hersteller"])) {
                $brands[] = $marque["Hersteller"];
            }
        }

        $form = $this->createForm(CodePeintureType::class, null, [
            //array_combine pour élimine les index.
            'marques' => array_combine($brands, $brands),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $brand = $form->get('Hersteller')->getData();
            $name_coleur = $form->get('name')->getData();

            if($name_coleur->getName() != 'Non'){
                $marques = $name_coleur;
            }
            else{
                $marques = $this->entityManager->getRepository(CodePeinture::class)->findByHersteller($brand);
            }

            foreach($marques as $marque){

                dd($marque->getName());
            }

        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/code_peinture.html.twig',[
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories,
            'form' => $form->createView(),
            'peintures'=>$marques,

        ]);
    }
}
