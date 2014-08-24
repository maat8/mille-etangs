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
            ->add('teaser', 'textarea', array('required' => false))
            ->add('access', 'textarea', array('required' => false))
            ->add('description', 'textarea')
            ->add('bikeLength')
            ->add('hikeLength')
            ->add('distance')
            ->add('incline')
            ->add('endomondoLink', null, array('required' => false))
            ->add('marked', null, array('required' => false))
            ->add('gpx', 'file')
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

    public function create($object)
    {
        if (!is_null($object->getGpx())) {
            $traceConverter = $this->getConfigurationPool()->getContainer()->get('trace_converter');
            try {
                $traceConverter->generateTracesFromFile($object->getGpx());
                $object->setGpx($traceConverter->getGpx());
                $object->setKml($traceConverter->getKml());
            } catch (\Exception $e) {
                // TODO
            }
        }

        parent::create($object);
    }

    public function update($object)
    {
        if (!is_null($object->getGpx())) {
            $traceConverter = $this->getConfigurationPool()->getContainer()->get('trace_converter');
            try {
                $traceConverter->generateTracesFromFile($object->getGpx());
                $object->setGpx($traceConverter->getGpx());
                $object->setKml($traceConverter->getKml());
            } catch (\Exception $e) {
                // TODO
            }
        }

        $this->getModelManager()->update($object);
    }
}
