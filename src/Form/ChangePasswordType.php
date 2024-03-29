<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Regex;


class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email'
            ])
            ->add('firstname',TextType::class,[
                'disabled' => true,
                'label' => 'Mon prénom'

            ])
            ->add('lastname',TextType::class,[
                'disabled' => true,
                'label'=> 'Mon nom'


            ])
            ->add('old_password', PasswordType::class,[
                'label'=> 'Mon mot de passe actuel',
                'mapped'=> false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'veuillez saisir le mot de passe actuel '
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'label' => 'Votre nouveau mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder'=> 'Merci de saisir votre nouveau mot de passe'
                    ]
            ],
                'second_options' =>[
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder'=> 'Merci de confirmer votre nouveau mot de passe'
                    ]
                ],
                'invalid_message' => 'le nouveau mot de passe et la confirmation doivent être identique.',

                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@])[A-Za-z\d@]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial (@).'
                    ])
                ],

            ])
           
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
