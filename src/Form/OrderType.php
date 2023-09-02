<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
        ->add('addresses', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Address::class,
            'choices' => $user->getAddresses(),
            'multiple' => false,
            'expanded' => false
        ])
        ->add('addressess', EntityType::class, [
            'label' => false,
            'required' => true,
            'class' => Address::class,
            'choices' => $user->getAddresses(),
            'multiple' => false,
            'expanded' => false
        ])
        ->add('carriers', EntityType::class, [
            'label' => false,
            'attr'=> [
                'class'=> 'text-bold',

            ],
            'required' => true,
            'class' => Carrier::class,
            'choice_label' => function ($carrier) {
                return $carrier->getName().' - '.$carrier->getDescription() ;
            },
            'multiple' => false,
            'expanded' => true
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Valider ma commande',
            'attr' => [
                'class' => 'btn btn-success btn-block'
            ]
        ])
    ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here

            'user' => array()


        ]);
    }
}
