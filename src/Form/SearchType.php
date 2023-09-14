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


        

        if ($options['showBusFilter']) {
            $builder
            ->add('buses', EntityType::class, [
                'class' => Buses::class,
                'placeholder' => 'Choose a bus',
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
            'showFiltrepeinture'=>false
        ]);
    }
    
    public function getBlockPrefix(){
        return '';
    }
}