<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Pays;
use App\Entity\VisaClassic;
use App\Form\Backend\MetaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class VisaClassicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', CheckboxType::class, [
                'attr' => [
                    'class' => '',
                ],
                'required'      =>false,
            ])
            ->add('pays', EntityType::class, [
                'class'     => Pays::class,
            ])

            ->add('slug', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'url-simplifie'
            ])
            ->add('position', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Position sur la page d\'accueil'
            ])
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
            ->add('communique', CKEditorType::class, [
                'label'     => 'Communiqué sous image d\'illustration'
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
            'data_class' => VisaClassic::class,
        ]);
    }
}