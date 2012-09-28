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
			->add('id', 'hidden')
			->add('nom', 'text')
            ->add('teaser', 'textarea', array('required' => false))
            ->add('acces', 'textarea', array('required' => false))
            ->add('description', 'textarea', array('required' => false))
            ->add('duree_vtt', 'text')
            ->add('duree_marche', 'text')
            ->add('duree_cheval', 'text')
            ->add('denivele_positif', 'text')
            ->add('distance', 'text')
            ->add('endomondo_link', 'text', array('required' => false))
            ->add('publie', 'checkbox', array('required' => false))
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