<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\DoccumentOfficiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FormulaireOfficielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control col-3 ml-1'
                ],
                'label'     => 'Titre du doccument',
                'required'  => false,
            ])

            ->add('doccumentOfficielFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true, 
                'download_uri' => true,
                'asset_helper' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DoccumentOfficiel::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'formulaire_type_add'
        ]);
    }
}