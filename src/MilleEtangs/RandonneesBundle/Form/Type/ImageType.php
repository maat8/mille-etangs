<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    const CUSTOMER_CLASS = 'MilleEtangs\RandonneesBundle\Document\Image';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file')
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
        return 'image';
    }
}
