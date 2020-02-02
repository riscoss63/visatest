<?php

namespace App\Form\Backend\Course;

use App\Entity\Course;
use App\Entity\Home;
use App\Entity\User;
use App\Form\Backend\MetaType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CourseEditType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control',
                    'placeholder'   => 'Remplire si le client n\'existe pas, sinon laissez se champ vide'
                ],
                'required'  => false
            ])
            ->add('prenom', TextType::class, [
                'attr'      => [
                    'class'     => 'form-control',
                    'placeholder'   => 'Remplire si le client n\'existe pas, sinon laissez se champ vide'
                ],
                'required'  => false
            ])
            ->add('dateEnlevement', TextType::class, [
                'label'     => 'Date de livraison/enlevement',
                'attr'      => [
                    'id'     => 'date-livraison',
                    'class'  => 'form-control'
                ],
                'mapped'       => false
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Adresse'
                ],
                'required'      => false
                
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Code postale'
                ],
                'required'      => false
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'   => 'Ville'
                ],
                'required'      => false
            ])
            ->add('coursier', EntityType::class, [
                'class'     => User::class,
                'choices' => $this->userRepository->findCoursier(),
                'choice_label' => 'prenom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required'      => false
            ])
            ->add('client', EntityType::class, [
                'class'     => User::class,
                'choices' => $this->userRepository->findClients(),
                'choice_label' => 'prenom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required'      => false
            ])
            ->add('livraison', CheckboxType::class,[
                'required'      => false,
                'attr' => [
                    'class' => 'form-control check',
                ],
            ])
            ->add('enlevement', CheckboxType::class, [
                'required'      => false,
                'attr' => [
                    'class' => 'form-control check',
                ],
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
            'csrf_protection'   => true,
            'csrf_field_name'   => '_token',
            'crsf_token_id'     => 'course_edit'
        ]);
    }
}