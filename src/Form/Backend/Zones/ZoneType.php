<?php

namespace App\Form\Backend\Zones;

use App\Entity\Pays;
use App\Entity\ZoneGeographique;
use App\Form\Backend\MetaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ZoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Libelle'
            ])
            ->add('pays', EntityType::class, [
                'class'     => Pays::class,
                'multiple'  => true,
                'by_reference'  => false,
                'attr'      => [
                    'class'     => 'my-select form-control',
                    'data-live-search'      => 'true',
                    'multiple title'        => 'Selectionner un pays'
                ]
            ])
            ->add('active', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-control check',
                ],
                'required'      =>false,
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
            'data_class' => ZoneGeographique::class,
            'csrf_protection'    => false
        ]);
    }
}