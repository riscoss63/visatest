<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\ReceptionDossier;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompletReceptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depot', ChoiceType::class, [
                'choices'   => [
                    '2 heures'      => new \DateTime('+2 hours'),
                    '4 heures'      => new \DateTime('+4 hours'),
                    '24 heures'     => new \DateTime('+1 day'),
                    '2 jours'       => new \DateTime('+2 days'),
                    '3 jours'       => new \DateTime('+3 days'),
                    '4 jours'       => new \DateTime('+4 days'),
                    '7 jours'       => new \DateTime('+7 days')
                ]
            ])
            ->add('submit', SubmitType::class)


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReceptionDossier::class,
        ]);
    }
}