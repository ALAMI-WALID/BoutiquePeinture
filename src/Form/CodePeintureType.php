<?php

namespace App\Form;

use App\Entity\CodePeinture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodePeintureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Hersteller', ChoiceType::class, [
                'label'=>'Marque',
                'choices' =>$options['marques'], // Utilisez les marques sans doublons comme choix
                'multiple' => false,
                'expanded' => false,
                'required'=>true,
            ])
            ->add('name',EntityType::class,[
                'label'=>'Choisissez le nom de la couleur (optionnel)',
                'class'=>CodePeinture::class,
                'choice_label' => 'name', // Utilize the 'subtitle' property as the choice label
                'choice_value' => 'name',

            ])

            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
                ]);
         
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CodePeinture::class,
            'marques' => [],
   
        ]);
    }
}
