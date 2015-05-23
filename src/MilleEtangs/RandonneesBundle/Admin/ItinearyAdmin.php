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
            ->add('image', 'sonata_type_model', array(
                'required' => false,
            ))
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
                'required' => false,
                'mapped' => false
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
        $this->updateTrace($object);

        return parent::create($object);
    }

    public function preUpdate($object)
    {
        $this->updateTrace($object);
    }

    private function updateTrace($object)
    {
        $upload = ($this->getForm()->get('gpx')->getData());
        if (!is_null($upload)) {
            $traceConverter = $this->getConfigurationPool()->getContainer()->get('trace_converter');
            $traceConverter->generateTracesFromFile($upload);
            $object->setGpx($traceConverter->getGpx());
            $object->setKml($traceConverter->getKml());
            $object->setStart($traceConverter->getStart());
        }
    }
}
