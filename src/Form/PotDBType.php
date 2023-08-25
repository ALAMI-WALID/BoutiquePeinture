<?php

namespace App\Form;

use App\Entity\PotBD;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PotDBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('potQ', EntityType::class,[
            'label'=>false,
            'class' => Potbd::class,
            'multiple'=>false,
            'expanded'=>false,
        ] )

        ->add('submit', SubmitType::class, [
            'label'=>'Search la disponibilité de pot',
            'attr'=>[
                'class'=> 'btn-block btn-info'
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PotBD::class,
        ]);
    }
}
