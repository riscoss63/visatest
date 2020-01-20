<?php

namespace App\Form\Backend\Assurance;

use App\Entity\PartenaireAssurance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireAssuranceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raisonSociale', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Raison sociale'
            ])
            ->add('adresse', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Adresse'
            ])
            ->add('complementAdresse', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Complément d\'adresse'
            ])
            ->add('codePostal', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Code postal'
            ])
            ->add('ville', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Ville'
            ])
            ->add('horaires', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Horaire exemple(7h-18h)'
            ])
            ->add('email', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Email'
            ])
            ->add('fixe', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Numéro de fixe'
            ])
            ->add('mobile', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Numéro mobile'
            ])
            ->add('siret', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Siret'
            ])
            ->add('siren', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Siren'
            ])
            ->add('tva', TextType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Taux de TVA en %'
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PartenaireAssurance::class,
        ]);
    }
}
