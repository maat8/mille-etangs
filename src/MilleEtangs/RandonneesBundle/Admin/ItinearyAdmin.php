<?php

namespace MilleEtangs\RandonneesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ItinearyAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add('teaser', 'textarea', array('required' => false))
            ->add('access', 'textarea', array('required' => false))
            ->add('description', 'textarea')
            ->add('mountainBikeLength', null, array('required' => false))
            ->add('roadBikeLength', null, array('required' => false))
            ->add('hikeLength', null, array('required' => false))
            ->add('distance')
            ->add('incline')
            ->add('difficulty')
            ->add('endomondoLink', null, array('required' => false))
            ->add('marked', null, array('required' => false))
            ->add('gpx', 'file', array(
                'data_class' => 'MilleEtangs\RandonneesBundle\Document\Trace',
                'required' => false
            ))
            ->add('published', null, array('required' => false))
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
            $traceConverter->generateTracesFromFile($object->getGpx());
            $object->setGpx($traceConverter->getGpx());
            $object->setKml($traceConverter->getKml());
        }

        return parent::create($object);
    }

    public function preUpdate($object)
    {
        if (!is_null($object->getGpx())) {
            $traceConverter = $this->getConfigurationPool()->getContainer()->get('trace_converter');
            $traceConverter->generateTracesFromFile($object->getGpx());
            $object->setGpx($traceConverter->getGpx());
            $object->setKml($traceConverter->getKml());
        } else {
            // Keep old GPX
        }
    }
}
