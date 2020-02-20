<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Frais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fraisConsulaire', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('quantiteConsulaire', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('fraisEdition', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('quantiteEdition', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('fraisLivraison', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('quantiteLivraison', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('fraisEnlevement', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('quantiteEnlevement', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('fraisFormulaire', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('quantiteFormulaire', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Frais::class,
        ]);
    }
}
