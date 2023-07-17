<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre du header')
            ->setFormTypeOptions([ 'required'=> false]),
            TextareaField::new('content', 'Contenu de notre header')
            ->setFormTypeOptions([ 'required'=> false]),
            TextField::new('btnTitle', 'Titre de notre bouton')
            ->setFormTypeOptions([ 'required'=> false]),
            TextField::new('btnUrl', 'Url de destination de notre bouton')
            ->setFormTypeOptions([ 'required'=> false]),
            ImageField::new('illustration')
            ->setBasePath('uploads/') // qui renvoye les photo pour affichier sur Dashboard
            ->setUploadDir('public/uploads') // pour stocké les photos 
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setFormTypeOptions([ 'required'=> false]), //  pour évite de stocké Data sur Illustration

        ];
    }
    
}
