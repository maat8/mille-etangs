<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActualiteType extends AbstractType
{
	const CUSTOMER_CLASS = 'MilleEtangs\RandonneesBundle\Entity\Actualite';

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('id', 'hidden')
			->add('categorie')
			->add('nom', 'text')
            ->add('message', 'textarea', array('required' => false))
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
		return 'actualite';
	}
}