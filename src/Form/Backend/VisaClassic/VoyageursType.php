<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Voyageurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VoyageursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Prenom'
                ],
                
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'nom'
                ],
                
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Sexe'
                ],
                'choices'       => [
                    'Homme'     => 'homme',
                    'Femme'     => 'femme'
                ]
                
            ])
            ->add('nationalite', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Nationalité'
                ],
                
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'choice',
            ])
            ->add('numeroPasseport', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voyageurs::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'voyageur_type_edit'
        ]);
    }
}