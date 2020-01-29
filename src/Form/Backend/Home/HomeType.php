<?php

namespace App\Form\Backend\Home;

use App\Entity\Home;
use App\Form\Backend\MetaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('meta', MetaType::class)
            ->add('images', CollectionType::class, [
                'entry_type'    => ImagesType::class,
                'entry_options' => [
                    'label' => false
                ],
                

                
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
            'data_class' => Home::class,
            'csrf_protection'       => false
        ]);
    }
}