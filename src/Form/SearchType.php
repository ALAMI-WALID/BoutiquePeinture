<?php
namespace App\Form;
use App\Classe\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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

        ->add('categories', EntityType::class, [
            'label'=>false,
            'required'=>false,
            'class'=>Category::class,
            'multiple'=>true,
            'expanded'=>true,
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