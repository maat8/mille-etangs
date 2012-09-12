<?php

namespace MilleEtangs\RandonneesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ParcoursType extends AbstractType
{
	const CUSTOMER_CLASS = 'MilleEtangs\RandonneesBundle\Entity\Parcours';

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nom', 'text')
			->add('slug', 'text', array('required' => false))
            ->add('description', 'textarea', array('attr' => array('class' => "tinymce")))
            ->add('description', 'textarea')
            ->add('duree_vtt', 'text')
            ->add('denivele_positif', 'text')
            ->add('distance', 'text')
            ->add('endomondo_link', 'text', array('required' => false))
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
		return 'parcours';
	}
}