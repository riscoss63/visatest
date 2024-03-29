<?php

namespace App\Form\Backend\Actualite;

use App\Entity\Actualite;
use App\Entity\CarteTourisme;
use App\Entity\EVisa;
use App\Entity\VisaClassic;
use App\Form\Backend\MetaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control',
                    'placeholder'   => 'Par défaut le méta-titre est selectionné'
                ]
            ])
            ->add('actif', CheckboxType::class, [
                'attr'      => [
                    'class'     => 'form-control check'
                ]
            ])
            ->add('visaClassic', EntityType::class, [
                'class'     => VisaClassic::class,
                'placeholder'   => '--Sélection du service Visa classic--',
                'required'      => false,
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('evisa', EntityType::class, [
                'class'     => EVisa::class,
                'placeholder'   => '--Sélection du service E-visa--',
                'required'      => false,
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('carteTourisme', EntityType::class, [
                'class'     => CarteTourisme::class,
                'placeholder'   => '--Sélection du service Carte de tourisme--',
                'required'      => false,
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('contenu', CKEditorType::class)
            ->add('meta', MetaType::class)
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_label' => true,
                'download_uri' => true,
                'image_uri' => true,
                // 'imagine_pattern' => '...',
                'asset_helper' => true,
                'label'     =>false
            ])
            
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
            'csrf_protection'   => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'actualite_type',
        ]);
    }
}
