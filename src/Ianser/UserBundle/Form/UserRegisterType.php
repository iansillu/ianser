<?php

namespace Ianser\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserRegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('username','text', array('label'=>"Username"))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Les contrasenyes tenen que coincidir',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Contrasenya'),
                'second_options' => array('label' => 'Repeteix contrasenya')))
            ->add('nombre','text', array('label'=>"Nom"))
            ->add('apellido','text', array('label'=>"Primer cognom"))
            ->add('apellido2','text', array('label'=>"Segon cognom"))
            ->add('ciudad','text', array('label'=>"Ciutat"))
            ->add('email','email')
            ->add('submit', 'submit', array('label' => 'Crear compte'))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ianser\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ianser_userbundle_userregister';
    }
}
