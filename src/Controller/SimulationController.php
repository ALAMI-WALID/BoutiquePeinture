<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Entity\CarType;
use App\Entity\PaintEstimations;
use App\Entity\PaintOptions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimulationController extends AbstractController
{

    private $entityManager;
    private $megaMenu;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }
    #[Route('/simulation', name: 'simulation', methods:['GET' | 'POST'])]
    public function index(Request $request): Response
    {
        //récupere Data
        $carTypes = $this->entityManager->getRepository(CarType::class)->findAll();
        $optionPaint = $this->entityManager->getRepository(PaintOptions::class)->findAll();
        $Estimation = $this->entityManager->getRepository(PaintEstimations::class)->findAll();
        // dd($Estimation[0]->getBombeQuantity());

        

        //les variable a rendu 
        $estimationBombe = null;
        $estimationPot = null;
        $estimationBombeMax = null;
        $estimationPotMax = null;
        
        //traitemet de resultas de Ajax 
        if($request->isMethod("POST")){

            //les variable de Ajax, recupere les valeur de cartype et optionPaint
            $carType = $request->request->get('carType');
            $selectedOptions = $request->request->get('selectedOptions');
         if($carType !== null && $selectedOptions!== null){

             foreach($Estimation as $estimationPaint){

                foreach($selectedOptions as $option){

                    if ($estimationPaint->getPaintOption()->getId() == $option && $estimationPaint->getCarType()->getId() ==  $carType) {
                        //Min
                        $estimationBombe =  $estimationBombe + $estimationPaint->getBombeMin();                        
                        $estimationPot = $estimationPot + $estimationPaint->getPaintMin();
                        //MAX
                        $estimationBombeMax = $estimationBombeMax + $estimationPaint->getBombeMax();
                        $estimationPotMax = $estimationPotMax + $estimationPaint->getPaintMax();

                    }
                }
            }
            //pour éliminer les elements egale 0 
            if ($estimationBombe == 0 ){
                $estimationBombe = "Non conseillé";
            }
            
        }
        return new JsonResponse([
            'estimationPot'=>$estimationPot,
            'estimationBombe'=>$estimationBombe,
            'estimationPotMax'=>$estimationPotMax,
            'estimationBombeMax'=>$estimationBombeMax,
        ]);
    }

    
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('simulation/index.html.twig', [
            'carTypes'=>$carTypes,
            'options'=>$optionPaint,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories,
            'estimationPot'=> $estimationPot,
            'estimationBombe'=>$estimationBombe,
            'estimationPotMax'=>$estimationPotMax,
            'estimationBombeMax'=>$estimationBombeMax,




        ]);
    }
}
