<?php

namespace MilleEtangs\RandonneesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use MilleEtangs\RandonneesBundle\Document\Trace;

class ItinearyAdmin extends Admin
{

	protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('teaser', 'textarea')
            ->add('access', 'textarea')
            ->add('description', 'textarea')
            ->add('bikeLength')
            ->add('hikeLength')
            ->add('distance')
            ->add('incline')
            ->add('endomondoLink')
            ->add('marked')
            ->add('gpx', 'file', array('data_class' => "MilleEtangs\RandonneesBundle\Document\Trace"))
        ;
    }
    
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('slug')
            ->add('created', 'timestamp')
            ->add('_action', 'actions', array(
	            'actions' => array(
	                'show' => array(),
	                'edit' => array(),
	                'delete' => array(),
	            )
	        ))
        ;
    }

    public function create($object) {
        if (!is_null($object->getGpx())) {
            $trace_gpx = new Trace();
            $trace_gpx->setFile($object->getGpx()->getPathName());
            $object->setGpx($trace_gpx);
        }

        parent::create($object);

        $object->generateKmlFromGpx();
        $this->getModelManager()->update($object);
    }

    public function update($object) {
        if (!is_null($object->getGpx())) {
            $trace_gpx = new Trace();
            $trace_gpx->setFile($object->getGpx()->getPathName());
            $object->setGpx($trace_gpx);
        }

        parent::create($object);

        $object->generateKmlFromGpx();
        $this->getModelManager()->update($object);
    }
}
