<?php

namespace App\Form\Backend\Actualite;

use App\Entity\PageDivers;
use App\Form\Backend\MetaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PageDiversType extends AbstractType
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
            'data_class' => PageDivers::class,
            'csrf_protection'   => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'actualite_type',
        ]);
    }
}
