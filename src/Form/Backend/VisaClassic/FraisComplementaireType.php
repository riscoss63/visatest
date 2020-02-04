<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\DoccumentOfficiel;
use App\Entity\FraisComplementaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FraisComplementaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Type de frais',
                'required'  => false,
            ])
            ->add('quantite', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Quantité(s)',
                'required'  => false,
            ])
            ->add('prixUnitaire', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control ml-1'
                ],
                'label'     => 'Prix unitaire',
                'required'  => false,
            ])
            ->add('total', TextType::class, [
                'attr'      => [
                    'class'     => 'total form-control ml-1'
                ],
                'label'     => 'Total',
                'required'  => false,
                'disabled'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FraisComplementaire::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'formulaire_complementaire_edit'
        ]);
    }
}