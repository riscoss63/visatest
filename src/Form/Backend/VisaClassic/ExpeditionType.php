<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Expedition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ExpeditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('suivi', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Titre du doccument',
                'required'  => false,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expedition::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'expedition_type_edit'
        ]);
    }
}