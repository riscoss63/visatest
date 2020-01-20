<?php

namespace App\Form\Backend\Assurance;

use App\Entity\PageAssurance;
use App\Form\Backend\MetaType;
use App\Form\Backend\VisaClassic\VoletInfoVisaClassicEditType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageAssuranceType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actif', CheckboxType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ]) 
            ->add('meta', MetaType::class)
            ->add('communique', CKEditorType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageAssurance::class,
        ]);
    }
}