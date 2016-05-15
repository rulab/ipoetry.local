<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of authority_user_form_type
 *
 * @author denvkr
 */
class authority_user_form_type extends AbstractType {
    //put your code here
public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'text')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\authority_user_form'
        ));
    }

    public function getName()
    {
        return 'authority_user_form';
    }
}
