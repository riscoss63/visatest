<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\DoccumentOfficiel;
use App\Entity\EtatDossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EtatDossierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control col-4'
                ],
                'label'     => false,
                'required'  => false,
            ])
            ->add('manquant', CheckboxType::class, [
                'attr'      => [
                    'class'     => 'form-control col-2'
                ],
                'label'     => 'Doccument manquant',
                'required'  => false,
            ])
            ->add('nonConforme', CheckboxType::class, [
                'attr'      => [
                    'class'     => 'form-control col-2'
                ],
                'label'     => 'Doccument non conforme',
                'required'  => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EtatDossier::class,
        ]);
    }
}