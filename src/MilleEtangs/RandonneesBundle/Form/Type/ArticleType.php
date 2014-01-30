<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    const CUSTOMER_CLASS = 'MilleEtangs\RandonneesBundle\Document\Article';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('name', 'text')
               ->add('content', 'textarea', array('required' => false))
               ->add('publication', 'date')
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
        return 'article';
    }
}
