<?php

namespace Ianser\BuscadorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BuscadorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('label'=>"Nom", 'required'=>false))
            ->add('direccion', 'text', array('label'=>"Carrer", 'required'=>false))
            ->add('ciudad', 'text', array('label'=>"Ciutat", 'required'=>false))
            ->add('tipo', 'choice', array(
                'choices'=>array(
                    'Al aire lliure'=> 'Al aire lliure',
                    'En un local'=> 'En un local',
                    ),
                'choices_as_values'=>true,
                'label'=>"Entorn",
                'required'=>false))
            ->add('aforo','integer',array('required'=>false))
            ->add('edad','integer', array('label'=>"Edat", 'required'=>false))
            ->add('gratuito', 'choice', array(
                'choices'=>array(
                    'Si'=> 1,
                    'No'=> 0,
                    ),
                'choices_as_values'=>true,
                'label'=>"Gratuit",
                'required'=>false
                ))
            ->add("Buscar","submit");
                    
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ianser\EventosBundle\Entity\Evento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ianser_buscadorbundle_buscador';
    }
}
