<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Demande;
use App\Entity\ReceptionDossier;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandeFraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fraisComplementaire', CollectionType::class, [
                'entry_type'        => FraisComplementaireType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'prototype'     => true,
                'attr'          => [
                    'class' => 'my-selector form',
                ],
                'by_reference'    =>false,
                'label'     => 'Frais complémentaire : '

            ])
            ->add('submit', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'FraisComplementaireType';
    }
}