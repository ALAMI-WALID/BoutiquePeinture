<?php
namespace App\Form;
use App\Classe\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchGlobalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('q', TextType::class, [
            'label'=>false,
            'required'=>false,
            'attr'=>[
                'placeholder'=> 'Rechercher via un mot clé...',
            ]

            ]);
        
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }

}