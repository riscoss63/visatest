<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\ModeExpedition;
use App\Entity\NotreService;
use App\Entity\Transport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Libellé',
                'required'  => true,
            ])
            ->add('libelleCourt', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Libellé court',
                'required'  => true,
            ])
            ->add('informations', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control  ml-1'
                ],
                'label'     => 'Informations Supplémentaire (Temps de livraison)',
                'required'  => false,
            ])
            ->add('tarif', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control  ml-1'
                ],
                'label'     => 'Tarif de la livraison global',
                'required'  => true,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_label' => true,
                'download_uri' => true,
                'image_uri' => true,
                // 'imagine_pattern' => '...',
                'asset_helper' => true,
                'label'     =>false,
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add('actif', CheckboxType::class, [
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
            'data_class' => Transport::class,
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'transport_edit'
        ]);
    }
}