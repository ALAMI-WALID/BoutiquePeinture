<?php
namespace App\Form;
use App\Classe\Search;
use App\Entity\Buses;
use App\Entity\Category;
use App\Entity\Contenance;
use App\Entity\PCFES;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class SearchType extends AbstractType
{
    
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        ->add('string', TextType::class, [
            'label'=>false,
            'required'=>false,
            'attr'=>[
                'placeholder'=> 'Votre recherche ...',
                'class'=>'from-control-5m',
                ]
                
            ])
                
        ->add('min', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'Prix min'
            ]
        ])

        ->add('max', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'Prix max'
            ]
        ])
        ->add('promo', CheckboxType::class, [
            'label' => 'En promotion',
            'required' => false,
            'mapped'=>true,
        ]);
        

        if ($options['showPotbombe']) {
            $builder
            ->add('potbombe', ChoiceType::class, [
                'choices' => [
                    'POT' => 'peinture',
                    'Bombe Aérosol' => 'bombe',
                ],
                'placeholder' => 'Sélectionnez un type',
                'label'=>'Type de contenance',
                'required'=>false
            ]);
        }
      
        


        if ($options['showFiltrebrands']) {
            $builder
            ->add('FiltreContenance', ChoiceType::class, [
                'choices' => [
                    'bombe aérosol' => 'bombe aérosol',
                    '0.5L'=>'0.5L',
                    '1L' => '1L',
                    '2L'=>'2L',
                    '2.5L'=>'2.5L',
                    '3L'=>'3L',
                    '3.5L'=>'3.75L'
                ],
                'placeholder' => 'Sélectionnez une option',
                'required'=>false

            ])
            ->add('marque', ChoiceType::class, [
                'choices' => [
                    'MIPA' => 'MIPA',
                    'TROTON' => 'TROTON',
                ],
                'placeholder' => 'Sélectionnez une option',
                'required'=>false
            ])

            ->add('pack', ChoiceType::class, [
                'choices' => [
                    'Pack vernis' => 'Pack vernis',
                    'Pack Durcisseur ' => 'Pack Durcisseur ',
                ],
                'placeholder' => 'Sélectionnez un Pack',
                'required'=>false
            ]);
        }
        

        if ($options['showBusFilter']) {
            $builder
            ->add('buses', EntityType::class, [
                'class' => Buses::class,
                'label'=>'Buses',
                'placeholder' => 'Choisissez un bus',
                'required' => false,
                'multiple' => true,
                'expanded' => true
    
            ]);
        }
        if ($options['showContenanceFilter']) {
            $builder
            ->add('Contenance', EntityType::class, [
                'class' => Contenance::class,
                'placeholder' => 'Choose a Contenance',
                'required' => false,
                'multiple' => true,
                'expanded' => true
    
            ]);
        }

        if ($options['showFiltrepeinture']) {
            $builder
            ->add('TypePeinture', EntityType::class, [
                'class' => PCFES::class,
                'placeholder' => 'Choose a Type Peinture',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ]);
        }

      
          
        if ($options['showFiltreDiluant']) {
            $builder
            ->add('Diluant', ChoiceType::class, [
                'choices' => [
                    'Diluant lent' => 'Diluant lent',
                    'Diluant rapide ' => 'Diluant rapide',
                ],
                'placeholder' => 'Tous les types',
                'label'=>'Type de Diluant',
                'required'=>false
            ]);
        }
        if ($options['showbrandspestole']) {
            $builder
            ->add('marquepestole', ChoiceType::class, [
                'choices' => [
                    'SATA' => 'SATA',
                    'IWATA' => 'IWATA',
                    'APP'=>'APP'
                ],
                'label'=>'Marque du Pistolet',
                'placeholder' => 'Toutes les marques',
                'required'=>false
            ]);

        }
         if ($options['showbrandsAbrasif']) {
            $builder
            ->add('marqueabrasif', ChoiceType::class, [
                'choices' => [
                    'MIRKA' => 'MIRKA',
                    'APP' => 'APP',
                    'MIPA'=>'MIPA'
                ],
                'label'=>'Marque',
                'placeholder' => 'Toutes les marques',
                'required'=>false
            ]);

        }
        if ($options['showGrain']) {
            $builder
            ->add('Grain', ChoiceType::class, [
                'choices' => [

                    'P40'=>'p40',
                    'P60'=>'P60',
                    'P80'=>'P80',
                    'P220'=>'P220',
                    'P240'=>'P240',
                    'P320'=>'P320',
                    'P400'=>'P400',
                    'P500'=>'P500',
                    'P600'=>'P600',
                    'P800'=>'P800',
                    'P1000'=>'P1000',
                    'P1200'=>'P1200',
                    'P1500'=>'P1500',
                    'P2000'=>'P2000',
                    'P3000'=>'P3000'              
                ],
                'label'=>'Grain',
                'placeholder' => 'Tous les Grain',
                'required'=>false
            ]);

        }
        if ($options['showPapiercale']) {
            $builder
            ->add('Papiercale', ChoiceType::class, [
                'choices' => [
                    '115X228mm'=>'115X228mm',
                    '70X420mm'=>'70X420mm',
                    '70x450mm'=>'70x450mm'         
                ],
                'label'=>'Dimension',
                'placeholder' => 'Tous les dimension',
                'required'=>false
            ]);

        }
        if ($options['showMatiereCale']) {
            $builder
            ->add('Matiere', ChoiceType::class, [
                'choices' => [
                    'Plastique '=>'plastique',
                    'Caoutchouc'=>'caoutchouc',
                    'Bois '=>'bois'
                            
                ],
                'label'=>'Matière',
                'placeholder' => 'Tous les Matériaux',
                'required'=>false
            ]);

        }
        if ($options['showQalitePapier']) {
            $builder
            ->add('qualitePapier', ChoiceType::class, [
                'choices' => [
                    'Papier à l\'eau' => 'papier à l eau',
                    'Papier à sec'=> 'papier à sec'
                            
                ],
                'label'=>'Qualité du Papier',
                'placeholder' => 'Toutes les Qualités',
                'required'=>false
            ]);

        }
        
        if ($options['showbrandMasquage']) {
            $builder
            ->add('bransMasquage', ChoiceType::class, [
                'choices' => [
                    'MIPA'=>'MIPA',
                    'APP'=>'APP'
                            
                ],
                'label'=>'Marque',
                'placeholder' => 'Toutes les marques',
                'required'=>false
            ]);

        }
        if ($options['showepaisseur']) {
            $builder
            ->add('epaisseur', ChoiceType::class, [
                'choices' => [
                    '18mm'=>'18mm',
                    '24mm'=>'24mm',
                    '36mm'=>'36mm',
                    '48mm'=>'48mm',
                ],
                'label'=>'Épaisseur du Ruban',
                'placeholder' => 'Toutes les Épaisseurs',
                'required'=>false
            ]);

        }

        $builder->add('submit', SubmitType::class, [
            'label'=>'Filtrer',
            'attr'=>[
                'class'=> 'btn-block btn-info'
            ]
            ])
        
        ->add('reset', ResetType::class, [
            'label' => 'Réinitialiser',
        ]);
        
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method'=>'GET',
            'crsf_protection' =>false,
            'showBusFilter' => false, 
            'showContenanceFilter'=>false,
            'showFiltrepeinture'=>false,
            'showFiltrebrands'=>false,
            'showFiltreCon'=>false,
            'showFiltreDiluant'=>false,
            'showbrandspestole'=>false,
            'showPotbombe'=>false,
            'showbrandsAbrasif'=>false,
            'showGrain'=>false,
            'showPapiercale'=>false,
            'showMatiereCale'=>false,
            'showQalitePapier'=>false,
            'showbrandMasquage'=>false,
            'showepaisseur'=>false,
        ]);
    }
    
    public function getBlockPrefix(){
        return '';
    }
}