<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Demande;
use App\Entity\Transport;
use App\Form\Backend\Evisa\VoyageurEvisaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entre', DateType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Date d\'entrée',
                'required'  => true,
                'widget' => 'choice',
            ])
            ->add('sortie', DateType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Date de sortie',
                'required'  => false,
                'widget' => 'choice',
            ])
            ->add('urgent', ChoiceType::class, [
                'choices'       => [
                    'Oui'       =>true,
                    'Non'       =>false
                ],
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('transport', EntityType::class, [
                'class'         =>Transport::class,
                'choice_label'  => 'titre'
            ])
            ->add('client', ClientType::class)
            ->add('voyageurs', CollectionType::class, [
                'entry_type'    => VoyageursType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'by_reference'  => false,
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
            'data_class' => Demande::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'demande_type_edit'
        ]);
    }
}