<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Classe\Search;
use App\Classe\SearchData;
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
use App\Entity\MarqueTeinte;
use App\Entity\SearchTeinte;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    private $entityManager;
    private $megaMenu;

    
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }


  

    #[Route('/', name: 'app_home' , methods: ['GET', 'POST'])]
    public function index(Request $request ): Response
    {


        
        $searchData = new SearchData();
        $form = $this->createForm(SearchGlobalType::class, $searchData);

        $form->handleRequest($request);


    //     if ($form->isSubmitted() && $form->isValid()) {

    //         dd($searchData->q);




    //         // $products = $this->entityManager->getRepository(Product::class)->findWithSearchGlobal($search);


    //         // $categories = $this->megaMenu->mega();
    //         // $Scategories = $this->megaMenu->megaS();
    //         // $SScategories = $this->megaMenu->megaSS();
    //         // if (empty($products)) {
                
                
    //         //     return $this->render('home/search.html.twig', [
    //         //         'products' => [],
    //         //         'search' => $form->createView(),
    //         //         'categories' =>$categories,
    //         //         'Scategories' => $Scategories,
    //         //         'SScategories'=>$SScategories
    //         //     ]);
    //         // }
    //         // return $this->render('home/search.html.twig',[
               
    //         //     'products' => $products,
    //         //     'search' => $form->createView(),
    //         //     'categories' =>$categories,
    //         //     'Scategories' => $Scategories,
    //         //     'SScategories'=>$SScategories
    
    //         // ]);
    //     } 
    //    else{

        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $headers = $this->entityManager->getRepository(Header::class)->findAll();


        //traaitemet de trouve code teinte : 
        // Récupérer la liste des marques avec leurs logos
            $data_marques = $this->entityManager->getRepository(MarqueTeinte::class)->findAll();
            $searchTeintes = $this->entityManager->getRepository(SearchTeinte::class)->findAll();

            // Initialiser la variable de résultat
            $result = null;

            // Traiter la requête POST si elle est envoyée
            if ($request->isMethod('POST')) {
                $marque_return = $request->request->get('Marque');
                if ($marque_return !== null) {
                    foreach ($searchTeintes as $searchTeinte) {
                        if ($marque_return == $searchTeinte->getMarque()->getId()) {
                            $result[] = $searchTeinte->getIllustration()->getIllustration();
                        }
                    }
                }
                // Retourner la réponse JSON avec le résultat returne Tableau 
                return new JsonResponse(['result' => json_encode($result)]);

    }




        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


        

        return $this->render('home/index.html.twig',[
            'products' => $products,
            'headers' => $headers,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories,
            'data_marques' => $data_marques, // Correction du nom de variable
            'result'=>$result,




        ]);
    
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

    #[Route('Devenir_partenaire', name: 'DP')]
    public function pro(): Response
    {
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();
        return $this->render('home/DP.html.twig',[
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
