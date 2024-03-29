<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom*',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3,
                                'max' => 30])],
                'attr'=> [
                    'placeholder'=> 'Merci de saisir votre Prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom*',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3,
                                'max' => 30])],
                'attr' => [
                    'placeholder'=> 'Merci de saisir votre Nom'
                ]
            ])
            ->add('email',EmailType::class, [
                'label' => 'Votre Email*',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3,
                                'max' => 30])],
                'attr' => [
                    'placeholder'=> 'Merci de saisir votre Email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'Votre mot de passe*',
                'required' => true,
                'first_options' => [
                    'label' => 'Entrez votre mot de passe*',
                    'attr' => [
                        'placeholder'=> 'Merci de saisir votre mot de passe'
                    ]
            ],
                'second_options' =>[
                    'label' => 'Confirmez votre mot de passe*',
                    'attr' => [
                        'placeholder'=> 'Merci de confirmer votre mot de passe '
                    ]
                ],
                'invalid_message' => 'le mot de passe et la confirmation doivent être identique.',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@~#_^*%\/+.:;\"-])[A-Za-z\d@~#_^*%\/+.:;\"-]{8,}$/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial (@).'
                    ])
                ],

            ])
           
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                
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
