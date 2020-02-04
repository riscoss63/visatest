<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\ReceptionDossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class IncompletReceptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etatDossier', CollectionType::class, [
                'entry_type'        => EtatDossierType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'prototype'     => true,
                'attr'          => [
                    'class' => 'my-selector form',
                ],
                'by_reference'    =>false,
                'label'     => 'Nature des documents manquants ou non conformes : '

            ])
            ->add('submit', SubmitType::class)


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReceptionDossier::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'incomplet_reception_edit'
        ]);
    }
}