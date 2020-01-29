<?php

namespace App\Form\Backend;

use App\Entity\Meta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('metaTitre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Balise HTML de titre'
            ])
            ->add('metaDescription', TextareaType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Balise META description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meta::class,
        ]);
    }
}
