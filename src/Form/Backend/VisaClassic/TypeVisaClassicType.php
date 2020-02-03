<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\CategorieVisa;
use App\Entity\Pays;
use App\Entity\VisaType;
use App\Form\Backend\MetaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TypeVisaClassicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories=$options['categories'];
        $builder
            ->add('active', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-control check',
                ],
                'required'      =>false,
            ])
            ->add('categorieVisa', EntityType::class, [
                'class'     => CategorieVisa::class,
                'choices'   =>  $categories,
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])

            ->add('titre', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Nom du type de visa'
            ])
            ->add('fraisFormulaireValide', CheckboxType::class, [
                'attr'      => [
                    'class'     => 'form-control check'
                ],
                'label'     => 'Option formulaire',
                'required'      =>false,
            ])
            ->add('fraisFormulaire', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Frais formulaire',
            ])
            ->add('typeEntre', ChoiceType::class, [
                'choices'       => [
                    'Simple'        => 'simple',
                    'Double'        => 'double',
                    'Multiple'      => 'multiple',
                ],
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('validite', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Validité'
            ])
            ->add('dureSejour', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Durée du séjour (en jours)'
            ])
            ->add('delaiObtention', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Délai d\'obtention (en jours)'
            ])
            ->add('fraisConsulaire', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Frais consulaires'
            ])
            ->add('fraisEdition', IntegerType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Frais édition de dossier'
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
            'data_class' => VisaType::class,
            'categories' => null,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id'   => 'type_evisa_edit',
            
        ]);
    }
}