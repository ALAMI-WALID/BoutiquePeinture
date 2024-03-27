<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Entity\MarqueTeinte;
use App\Entity\SearchTeinte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class TeinteController extends AbstractController
{
    private $entityManager;

    private $megaMenu;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }


    
#[Route('/teinte', name: 'teinte', methods: ['GET', 'POST'], options: ['sitemap'=> ['section' =>'search_teint']])]
public function index(Request $request): Response
{
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

    // Rendre le template pour la méthode GET
    $categories = $this->megaMenu->mega();
    $Scategories = $this->megaMenu->megaS();
    $SScategories = $this->megaMenu->megaSS();

    return $this->render('teinte/index.html.twig', [
        'data_marques' => $data_marques, // Correction du nom de variable
        'categories' => $categories,
        'Scategories' => $Scategories,
        'SScategories' => $SScategories,
        'result'=>$result,
    ]);
}
}
