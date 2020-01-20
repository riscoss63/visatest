<?php

namespace App\Form\Backend\Assurance;

use App\Entity\Assurance;
use App\Entity\Pays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssuranceType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pays', EntityType::class, [
                'class'     => Pays::class
            ])
            ->add('tarif', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('typeDuree', ChoiceType::class, [
                'choices'   => [
                    '- d\'un mois'  => '-1_mois',
                    '+ d\'un mois'  => '+1_mois'
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}