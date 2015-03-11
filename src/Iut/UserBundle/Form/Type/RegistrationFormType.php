<?php

namespace Iut\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       parent::buildForm($builder, $options);
 
       $builder
           ->add('roles', 'collection', array(
                   'type' => 'choice',
                   'options' => array(
                       'choices' => array(
                           'ROLE_ADMIN' => 'Admin',
                           'ROLE_USER' => 'Gestionnaire'
                       )
                   )
               )
           )
       ;
   }

    public function getName()
    {
        return 'iut_user_registration';
    }
}