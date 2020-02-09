<?php

namespace App\Form\Frontend\Paiement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MoneticoType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formdata = $options['moneticodata'];
        
        /* @var Parameter $parameters */
        foreach ($formdata as $key => $value) {
            if ($key === 'texte-libre') {
                $value = html_entity_decode($value);
            }
            $builder->add($key, HiddenType::class, array(
                'data' => $value,
                'required'  => false,
                'attr'  => [
                    'id'    => $key,
                    'name'  => $key
                ],
                'id'    => $key
            ));
        }
        $builder->setAction($options['action']);
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
