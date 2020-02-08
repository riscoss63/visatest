<?php

namespace App\Form\Frontend\Paiement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class MoneticoType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formdata = $options['moneticodata'];
        
        $builder->add('payment', OrderPaymentType::class, array(
            'mapped' => false,
        ));
        
        /* @var Parameter $parameters */
        foreach ($formdata as $key => $value) {
            if ($key === 'texte-libre') {
                $value = html_entity_decode($value);
            }
            $builder->add($key, HiddenType::class, array(
                'data' => $value,
                'mapped' => false,
            ));
        }
        $builder->setAction($options['action']);
    }
    
    public function getBlockPrefix()
    {
        return null;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//             'data_class' => Order::class,
            'moneticodata' => null,
            'action' => null,
            'attr' => array('id' => 'PaymentRequest'),
//             'csrf_protection' => false,
        ]);
    }
}
