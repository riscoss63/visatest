<?php

namespace App\Form\Backend\Course;

use App\Entity\Course;
use App\Entity\Home;
use App\Form\Backend\MetaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ]
            ])
            ->add("signature", HiddenType::class, [
                "label" => "Signature",
                "attr" => ["class" => "champ_signature"],
                "required" => false
            ])
            ->add('submit', SubmitType::class, [
                'attr'  => [
                    'class'     => 'mt-3 form-control btn btn-primary btn-enregistrer-signature'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}