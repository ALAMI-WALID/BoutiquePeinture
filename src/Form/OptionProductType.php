<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



//étape 1  : cree  le formulaire de recherche et ajoutez les champs que vous voulez 
//étape  2 : utiliser ce formulaire dans votre controller pour récupérer les données du formulaire
class OptionProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
            // ->add('name')
            // ->add('slug')
            // ->add('illustration')
            // ->add('subtitle')
            // ->add('description')
            // ->add('price')
            // ->add('weight')
            // ->add('articleCode')
            // ->add('livrableHorsIleDeFrance')
            // ->add('isBest')
            // ->add('promo')
            // ->add('FiltreContenance')
            // ->add('PackVernisFiltre')
            // ->add('Diluant')


            if ($options['GrainMousseForm']) {
                $builder
                ->add('Grain', ChoiceType::class, [
                    'choices' => [
                        'P800'=>'MF P800',
                        'P1000'=>'MF P1000',
                        'P2000'=>'MF P2000',
                        'P3000'=>'MF P3000',
                        'P4000'=>'MF P4000',
                        'P5000'=>'MF P5000'             
                    ],
                    'label'=>'Grain',
                    'placeholder' => false,
                    'required'=>false
                ]);
            }

            if ($options['GrainMirkaForm']) {
                $builder
                ->add('Grain', ChoiceType::class, [
                    'choices' => [
                        'P40'=>'Mk P40',
                        'P60'=>'Mk P60',
                        'P80'=>'Mk P80',
                        'P120'=>'Mk P120',
                        'P150'=>'Mk P150',
                        'P180'=>'Mk P180',
                        'P240'=>'Mk P240',
                        'P320'=>'Mk P320',
                        'P400'=>'Mk P400',
                        'P500'=>'Mk P500',
                        'P600'=>'Mk P600'


                    ],
                    'label'=>'Grain',
                    'placeholder' => false,
                    'required'=>false
                ]);
            }

            if ($options['GrainDisqueBleu']) {
                $builder
                ->add('Grain', ChoiceType::class, [
                    'choices' => [
                        'P40'=>'DB P40',
                        'P60'=>'DB P60',
                        'P80'=>'DB P80',
                        'P120'=>'DB P120',
                        

                    ],
                    'label'=>'Grain',
                    'placeholder' => false,
                    'required'=>false
                ]);
            }

            if ($options['GrainDisqueAbrasif']) {
                $builder
                ->add('Grain', ChoiceType::class, [
                    'choices' => [
                        'P1000'=>'DA P1000',
                        'P1500'=>'DA P1500',
                        'P2000'=>'DA P2000',
                        'P2500'=>'DA P2500',
                                   
                    ],
                    'label'=>'Grain',
                    'placeholder' => false,
                    'required'=>false
                ]);
            }

            if ($options['GrainDisqueAlamelle']) {
                $builder
                ->add('Grain', ChoiceType::class, [
                    'choices' => [
                        'P40'=>'DL P40',
                        'P60'=>'DL P60',
                        'P80'=>'DL P80',
                        'P120'=>'DL P120',
                        

                    ],
                    'label'=>'Grain',
                    'placeholder' => false,
                    'required'=>false
                ]);
            }

            
            if ($options['TailleGobelet']) {
                $builder
                ->add('tailleGobelet', ChoiceType::class, [
                    'choices' => [
                        '385 ml'=>'385 ml',
                        '750 ml'=>'750 ml',
                        '1400 ml'=>'1400 ml',
                        '2300 ml'=> '2300 ml',
                        


                        
                    ],
                    'label'=>'Taille Gobelet',
                    'placeholder' => false,
                    'required'=>false
                ]);
    
            }






            if ($options['TailleRuban']) {
                $builder
                ->add('epaisseurRuban', ChoiceType::class, [
                    'choices' => [
                        '6mm x 5m'=>'6mm x 5m',
                        '9mm x 5m'=>'9mm x 5m',
                        '12mm x 5m'=>'12mm x 5m',
                        '19mm x 5m'=>'19mm x 5m',
                        '25mm x 5m'=>'25mm x 5m',
                        '6mm x 10m'=>'6mm x 10m',
                        '9mm x 10m'=>'9mm x 10m',
                        '12mm x 10m'=>'12mm x 10m',
                        '19mm x 10m'=>'19mm x 10m',
                        '25mm x 10m'=>'25mm x 10m',
                    ],
                    'label'=>'Épaisseur du Ruban',
                    'placeholder' => false,
                    'required'=>false
                ]);
    
            }
            

            // ->add('dimensionCale')
            // ->add('matierePapier')
            // ->add('qualitePapier')
            // ->add('epaisseurRuban')
            // ->add('DimensionPapierCacher')
            // ->add('colorsAppret')
            // ->add('raccordAir')
            // ->add('DimensionTuyau')
            // ->add('typeTuyau')
            // ->add('dimensionfiltreCabine')
            // ->add('typeFiltreCabine')
            // ->add('tailleEquipementProtection')
            // ->add('technique')
            // ->add('LienExterne')
            // ->add('stock')
            // ->add('category')
            // ->add('SScategory')
            // ->add('Scategory')
            // ->add('buses')
            // ->add('Size_Gobelet')
            // ->add('FiltrePeinture')
            $builder
            ->add('submit', SubmitType::class, [
                'label'=>'TROUVEZ VOS PRODUITS',
                'attr'=>[
                    'class'=> 'btn-block btn-info'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'method'=>'GET',
            'csrf_protection'=>false,
            'GrainMousseForm'=>false,
            'GrainMirkaForm'=>false,
            'GrainDisqueBleu'=>false,
            'GrainDisqueAbrasif'=>false,
            'GrainDisqueAlamelle'=>false,
            'TailleRuban'=>false,
            'TailleGobelet'=>false,
        ]);
    }
}
