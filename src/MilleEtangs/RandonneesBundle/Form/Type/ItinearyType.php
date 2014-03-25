<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItinearyType extends AbstractType
{
    const CUSTOMER_CLASS = 'MilleEtangs\RandonneesBundle\Document\Itineary';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('name', 'text')
            ->add('teaser', 'textarea', array('required' => false))
            ->add('access', 'textarea', array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->add('bike_length', 'text')
            ->add('hike_length', 'text')
            ->add('incline', 'text')
            ->add('distance', 'text')
            ->add('endomondo_link', 'text', array('required' => false))
            ->add('gpx', 'file', array('required' => false))
            ->add('marked', 'checkbox', array('required' => false))
            ->add('difficulty', 'choice', array('required' => false, 'choices' => array(
                1 => 1,
                2 => 2,
                3 => 3,
            )))
            ->add('published', 'checkbox', array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => self::CUSTOMER_CLASS
        ));
    }

    public function getName()
    {
        return 'itineary';
    }
}
