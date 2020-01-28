<?php

namespace App\Form\Backend\Utilisateurs;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('droits', ChoiceType::class, [
                'choices'       => [
                    'Utilisateur'       => 'ROLE_USER',
                    'SuperAdministrateur'   => 'ROLE_SUPERADMIN',
                    'Administrateur secondaire' => 'ROLE_ADMIN',
                    'Coursier'      => 'ROLE_COURSIER',
                    'Rédacteur'     => 'ROLE_REDACTEUR'
                ],
                'expanded'  => true,
                'multiple'  => true,
                'compound'  =>true,
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'choice_attr'   => [
                    'Utilisateur'   => [
                        'class'     => ''
                    ]
                ]
            ])
            ->add('service', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control '
                ],
                'disabled'      =>true,
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
            'data_class' => Services::class,
        ]);
    }
}