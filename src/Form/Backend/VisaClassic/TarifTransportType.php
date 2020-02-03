<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Departemente;
use App\Entity\TarifTransport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TarifTransportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zone', ChoiceType::class, [
                'choices'       => [
                    'France métropolitaine'     => 'france_metropolitaine',
                    'Pays d\'Europe'            => 'pays_europe',
                    'France DOM TOM'            => 'dom_tom',
                    'Autre pays'                => 'autre_pays'
                ],
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Zone application tarif',
                'required'  => true,
            ])
            ->add('departement', EntityType::class, [
                'class'     => Departemente::class,
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ]
            ])
            ->add('prix', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control  ml-1'
                ],
                'label'     => 'Prix',
                'required'  => true,
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
            'data_class' => TarifTransport::class,
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'tarif_transport_edit'
        ]);
    }
}