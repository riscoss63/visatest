<?php

namespace App\Form\Backend\Assurance;

use App\Entity\Assurance;
use App\Entity\AttestationAssurance;
use App\Entity\Pays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AttestationType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Nom du fichier'
            ])
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true, 
                'download_uri' => true,
                'asset_helper' => true,
                'label'         => 'Attestation',
                'attr'      => [
                    'class'     => 'form-control my-3'
                ],
            ])
            
            ->add('submit', SubmitType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttestationAssurance::class,
        ]);
    }
}