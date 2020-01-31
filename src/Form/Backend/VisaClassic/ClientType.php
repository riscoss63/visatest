<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Demande;
use App\Entity\Transport;
use App\Entity\User;
use App\Entity\Voyageurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valide', CheckboxType::class, [
                'required'      =>false
            ])   
            ->add('premium', CheckboxType::class, [
                'required'      =>false
            ]) 
            ->add('pays', CountryType::class, 
            [ 
                'label' => 'Pays de naissance*',
                'preferred_choices' => ['FR'],
                'choice_translation_locale' => null,
                'attr'  =>[
                    'class'     => 'form-control classic-select input-width selectpicker countrypicker'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Adresse'
                ],
                'required'      => false
                
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Code postale'
                ],
                'required'      => false
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Ville'
                ],
                'required'      => false
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Numéro de téléphone'
                ],
                'required'      => false
            ])

            ->add('voyageurs', CollectionType::class, [
                'entry_type'        => VoyageursType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'required'      => false,
                'attr'          => [
                    'class' => 'my-selector form',
                ],
                'by_reference'    =>false

            ])
            ->add('nom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('email', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => [
                    'class'     => 'mt-3 form-control btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}