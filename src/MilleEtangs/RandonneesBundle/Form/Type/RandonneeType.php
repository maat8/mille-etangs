<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RandonneeType extends AbstractType
{
	const CUSTOMER_CLASS = 'MilleEtangs\RandonneesBundle\Entity\Randonnee';

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', 'text')
			->add('slug', 'text')
            ->add('description', 'textarea')
            ->add('duree_vtt', 'text')
            ->add('endomondo_link', 'text')
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
		return 'randonnee';
	}
}