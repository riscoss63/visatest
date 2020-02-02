<?php

namespace App\Form\Backend\Utilisateurs;

use App\Entity\Services;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('services', EntityType::class, [
                'class'     => Services::class,
                'multiple'  => true,
                'by_reference'  => false,
                'attr'      => [
                    'class'     => 'form-control my-select',
                    'data-live-search'      => 'true',
                    'multiple title'        => 'Selectionner un service'
                ],
                'required'      => false
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
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Adresse mail'
                ],
                
            ])    
            ->add('submit', SubmitType::class, [
                'attr'  => [
                    'class'     => 'form-control btn btn-primary'
                ]
            ])
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
