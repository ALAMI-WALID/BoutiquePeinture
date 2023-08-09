<?php
namespace App\Classe;

use App\Entity\Category;
use App\Entity\SousSousCategory;
use App\Entity\SousCategory;
use Doctrine\ORM\EntityManagerInterface;

class MegaMenu
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function mega()
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return $categories;
    }
    public function megaS(){
        $Scategories = $this->entityManager->getRepository(SousCategory::class)->findAll();
        return $Scategories;
    }
    public function megaSS(){
        $SScategories = $this->entityManager->getRepository(SousSousCategory::class)->findAll();
        return $SScategories;
    }
}
