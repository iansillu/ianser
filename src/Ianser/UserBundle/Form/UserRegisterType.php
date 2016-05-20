<?php

namespace Ianser\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password','text', array('label'=>"Contrasenya"))
            ->add('nombre','text', array('label'=>"Nom"))
            ->add('apellido','text', array('label'=>"Primer cognom"))
            ->add('apellido2','text', array('label'=>"Segon cognom"))
            ->add('ciudad','text', array('label'=>"Ciutat"))
            ->add('email','email')
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
        return 'ianser_userbundle_user';
    }
}
