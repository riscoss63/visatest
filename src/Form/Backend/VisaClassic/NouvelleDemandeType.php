<?php

namespace App\Form\Backend\VisaClassic;

use App\Entity\Assurance;
use App\Entity\Demande;
use App\Entity\Transport;
use App\Entity\User;
use App\Entity\VisaType;
use App\Form\Backend\Evisa\VoyageurEvisaType;
use App\Repository\TransportRepository;
use App\Repository\UserRepository;
use App\Repository\VisaTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NouvelleDemandeType extends AbstractType
{
    private $client;
    private $visaType;
    private $transport;

    public function __construct(UserRepository $er, VisaTypeRepository $visaType, TransportRepository $transport)
    {
        $this->client = $er->findClients();
        $this->visaType = $visaType->findVisaClassic();
        $this->transport = $transport->findVisaClassic();
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client', EntityType::class, [
                'class'     => User::class,
                'choices'   => $this->client,
                'required'  => false,
            ])
            ->add('clientInscription', ClientType::class, [
                'mapped'        => false,
                'required'      => false
            ])
            ->add('visaType', EntityType::class, [
                'class'     => VisaType::class,
                'choices'   => $this->visaType,
                'choice_label'  => function($visaType) {
                    return $visaType->getVisaClassic()->getPays()->getTitre() .' - '. $visaType->getCategorieVisa()->getTitre() .' - '. $visaType->getTypeEntre() .' - validite: '.  $visaType->getValidite() .' - durée: '. $visaType->getDureSejour();
                }
            ])
            ->add('entre', DateType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Date d\'entrée',
                'required'  => true,
                'widget' => 'choice',
            ])
            ->add('sortie', DateType::class, [
                'attr'      => [
                    'class'     => 'form-control'
                ],
                'label'     => 'Date de sortie',
                'required'  => false,
                'widget' => 'choice',
            ])
            ->add('urgent', ChoiceType::class, [
                'choices'       => [
                    'Oui'       =>true,
                    'Non'       =>false
                ],
                'attr'      => [
                    'class'     => 'form-control'
                ],
            ])
            ->add('transport', EntityType::class, [
                'class'         =>Transport::class,
                'choice_label'  => 'titre', 
                'attr'  => [
                    'class'     => 'form-control'
                ],
                'choices' => $this->transport
            ])
            
            ->add('voyageurs', CollectionType::class, [
                'entry_type'    => VoyageursType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'my-selector form',
                ],
                
            ])
            ->add('assurance', EntityType::class, [
                'class'         =>Assurance::class,
                'choice_label'  => function($assurance) {
                    return $assurance->getDuree() .' jours';
                }, 
                'attr'  => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('quantiteAssurance', IntegerType::class, [
                'attr'  => [
                    'class'     => 'form-control'
                ]
            ])
            ->add('fraisComplementaire', CollectionType::class, [
                'entry_type'    => FraisComplementaireType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'my-selector2 form',
                ],
                
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
            'data_class' => Demande::class,
            'csrf_protection'       => true,
            'csrf_field_name'       => '_token',
            'crsf_token_id'         => 'nouvelle_demande_edit'
        ]);
    }
}