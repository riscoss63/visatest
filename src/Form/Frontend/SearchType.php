<?php
namespace App\Form\Frontend;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label'     => false,
                'attr'      => [
                    'class'     => 'form-control localisation-input gray-variant on-desktop',
                    'placeholder'   => 'Pays de destinations',
                    'aria-label'    => 'Pays de destinations'
                ],
                'required'      => false,
            ])
            ->add('visa', ChoiceType::class, [
                'choices'   => [
                    'Visa classic'      => 'classic',
                    'Evisa'             => 'evisa'
                ],
                'required'      => false,
                'attr'          => [
                    'class'     => 'form-control',
                    'id'        => 'visa-type'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => SearchData::class,
            'method'            => 'GET',
            'csrf_protection'   => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '' ;
    }
}