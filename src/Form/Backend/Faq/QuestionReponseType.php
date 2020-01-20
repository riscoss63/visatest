<?php

namespace App\Form\Backend\Faq;

use App\Entity\QuestionReponseFaq;
use App\Entity\SujetFaq;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', CKEditorType::class)
            ->add('reponse', CKEditorType::class)
            ->add('sujetFaq', EntityType::class, [
                'class'     => SujetFaq::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestionReponseFaq::class,
        ]);
    }
}
