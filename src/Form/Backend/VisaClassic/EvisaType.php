<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\EVisa;
use App\Entity\Pays;
use App\Form\Backend\MetaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EvisaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-control check',
                ],
                'required'      =>false,
            ])
            ->add('pays', EntityType::class, [
                'class'     => Pays::class,
                'attr'  => [
                    'class'     => 'form-control'
                ]
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
                'label'     =>false,
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('communique', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
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
            'data_class' => EVisa::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'evisa_edit'
        ]);
    }
}