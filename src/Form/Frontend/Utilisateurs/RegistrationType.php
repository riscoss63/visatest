<?php

namespace App\Form\Frontend\Utilisateurs;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Adresse mail'
                ],
                
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Mot de passe'
                ],
                
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Nom de famille'
                ],
                
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Prénom'
                ],
                
            ])
            // ->add('pays', CountryType::class, 
            // [ 
            //     'label' => 'Pays de naissance*',
            //     'preferred_choices' => ['FR'],
            //     'choice_translation_locale' => null,
            //     'attr'  =>[
            //         'class'     => 'form-control classic-select input-width selectpicker countrypicker'
            //     ]
            // ])
            // ->add('adresse', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder'   => 'Adresse'
            //     ],
                
            // ])
            // ->add('codePostal', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder'   => 'Code postale'
            //     ],
                
            // ])
            // ->add('ville', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder'   => 'Ville'
            //     ],
                
            // ])
            // ->add('telephone', TextType::class, [
            //     'attr' => [
            //         'class' => 'form-control',
            //         'placeholder'   => 'Numéro de téléphone'
            //     ],
                
            // ])
            // ->add('type', ChoiceType::class, [
            //     'choices'   => [
            //         'Particulier'   => 'particulier',
            //         'Professionnel' => 'professionnel'
            //     ],
            //     'attr' => [
            //         'class' => 'form-control',
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
            // 'csrf_field_name' => '_token',
            // // an arbitrary string used to generate the value of the token
            // // using a different string for each form improves its security
            // 'csrf_token_id'   => 'registration_item',
        ]);
    }
}
