<?php

namespace App\Form\Backend\Continents;

use App\Entity\Continent;
use App\Entity\ZoneGeographique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContinentType extends AbstractType
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
            ->add('zonesGeographique', EntityType::class, [
                'class'     => ZoneGeographique::class,
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
                    'class' => '',
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
            'data_class' => Continent::class,
        ]);
    }
}