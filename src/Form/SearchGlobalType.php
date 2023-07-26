<?php
namespace App\Form;
use App\Classe\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchGlobalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('string', TextType::class, [
            'label'=>false,
            'required'=>false,
            'attr'=>[
                'placeholder'=> 'Rechercher PeintureAutoExpert.com',
                'class'=>'form-control ma-input'
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