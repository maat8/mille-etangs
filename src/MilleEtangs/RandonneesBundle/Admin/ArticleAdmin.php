<?php

namespace MilleEtangs\RandonneesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleAdmin extends Admin
{

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('text', 'text')
            ->add('body')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('slug')
            ->add('publication')
            ->add('_action', 'actions', array(
	            'actions' => array(
	                'show' => array(),
	                'edit' => array(),
	                'delete' => array(),
	            )
	        ))
        ;
    }
}
