<?php

namespace Ianser\EventosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array('label'=>"Nom"))
            ->add('imageFile', 'vich_file', array('required'=>true, 'allow_delete'=> false, 'download_link'=>false, 'label'=>"Imatge"))
            ->add('direccion', 'text', array('label'=>"Carrer"))
            ->add('ciudad', 'text', array('label'=>"Ciutat"))
            ->add('descripcion', 'textarea', array('label'=>"Descripció"))
            ->add('tipo', 'choice', array(
                'choices'=>array(
                    'Al aire lliure'=> 'Al aire lliure',
                    'En un local'=> 'En un local',
                    ),
                'choices_as_values'=>true,
                'label'=>"Entorn"))
            ->add('aforo','integer', array('attr'=>array('min'=>0)))
            ->add('edad','integer', array('label'=>"Edat", 'attr'=>array('min'=>0, 'max'=>120)))
            ->add('gratuito', 'choice', array(
                'choices'=>array(
                    'Si'=> 1,
                    'No'=> 0,
                    ),
                'choices_as_values'=>true,
                'label'=>"Gratuit",
            ));
            
        
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
        return 'ianser_eventobundle_evento';
    }
}
