<?php

namespace App\Form\Backend\Pays;

use App\Entity\Pays;
use App\Entity\ZoneGeographique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zoneGeographique', EntityType::class, [
                'class'     => ZoneGeographique::class,
                'attr'      => [
                    'class'     => 'form-control'
                ]
                
            ])
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Libellé'
            ])
            ->add('iso', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Code ISO du pays'
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
            'data_class' => Pays::class,
            'csrf_protection'   => false
        ]);
    }
}