<?php
namespace App\Form;
use App\Classe\Search;
use App\Entity\Buses;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
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
                
                // ->add('categories', EntityType::class, [
        //     'label'=>false,
        //     'required'=>false,
        //     'class'=>Category::class,
        //     'multiple'=>true,
        //     'expanded'=>true,
        // ])


         
        
        ->add('buses', EntityType::class, [
                'label'=>false,
                'class' => Buses::class,
                'choice_filter'=>'size',
                'placeholder'=>'Par buses',
                'required'=>false,
               
        ])

        ->add('subtitle', EntityType::class, [
            'label' => false,
            'required' => false,
            'class' => Product::class,
            'multiple' => true,
            'expanded' => true,
            'query_builder' => function(ProductRepository $cr) {
                return $cr->createQueryBuilder('p')
                    ->orderBy('p.id');
            },
            'choice_label' => 'subtitle', // Utilize the 'subtitle' property as the choice label
            'choice_value' => 'subtitle',

        ])
        


        // ->add('subtitle', EntityType::class, array(
        //     'class'=> Product::class,
        //     'placeholder'=>'Par marques',
        //     'label'=>'subtite',
        //     'query_builder' => function(EntityRepository $er) {
        //         return $er->createQueryBuilder('p')
        //             ->orderBy('p.subtitle');
        //     },
        //     'choice_label' => 'subtitle',
        //     'choice_value' => 'subtitle',
          
        // ))

        // ->add('subtitle', EntityType::class, [
        //     'class' => Product::class,
        //     'query_builder' => function(ProductRepository $cr) {
        //         return $cr->createQueryBuilder('p')
        //             ->orderBy('p.subtitle');
        //     },
        //     'choice_label' => 'subtitle', // Use the 'subtitle' property as the choice label
        //     'required' => false,
        //     'choice_value' => 'subtitle',
        //     'label' => false, // Add a label to the field
        //     'placeholder' => 'sélectionne la marque', // Optionally add a placeholder
        // ])

        
        
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
        ])


        ->add('submit', SubmitType::class, [
            'label'=>'Filtrer',
            'attr'=>[
                'class'=> 'btn-block btn-info'
            ]
        ])
        ;
        
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method'=>'GET',
            'crsf_protection' =>false,
        ]);
    }
    
    public function getBlockPrefix(){
        return '';
    }
}