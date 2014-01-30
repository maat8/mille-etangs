<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', 'text')
            ->add('_password', 'password')
        ;
    }

    public function getName()
    {
        return "login";
    }
}
