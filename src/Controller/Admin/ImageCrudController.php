<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Entity\Product;
class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product'),
            ImageField::new('illustration')
            ->setBasePath('uploads/') // qui renvoye les photo pour affichier sur Dashboard
            ->setUploadDir('public/uploads/') // pour stocké les photos 
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setFormTypeOptions([ 'required'=> false]), //  pour évite de stocké Data sur Illustration

        ];
    }
    
}
