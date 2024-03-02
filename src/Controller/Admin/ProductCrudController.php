<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;



class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('articleCode'),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            NumberField::new('stock'),
            ImageField::new('illustration')
            ->setBasePath('uploads/') // qui renvoye les photo pour affichier sur Dashboard
            ->setUploadDir('public/uploads') // pour stocké les photos 
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setFormTypeOptions([ 'required'=> false]), //  pour évite de stocké Data sur Illustration
            TextField::new('subtitle'),
            NumberField::new('weight'),
            TextareaField::new('description'),
            ImageField::new('technique')
            ->setBasePath('uploads/technique/') 
            ->setUploadDir('public/uploads/technique'),
            BooleanField::new('isBest'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('category'),
            AssociationField::new('Scategory'),
            AssociationField::new('SScategory'),
            // AssociationField::new('buses'),
            BooleanField::new('promo'),
            BooleanField::new('livrableHorsIleDeFrance','livrable-Hors-IleDeFrance'),
            BooleanField::new('hiddenProduit','Hidden_Produit'),
        ];
    }
    
}
