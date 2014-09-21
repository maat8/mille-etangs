<?php

namespace MilleEtangs\RandonneesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use MilleEtangs\RandonneesBundle\Document\Image;

class ImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('file', 'file', array(
                'data_class' => "Doctrine\MongoDB\GridFSFile"
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('title')
            ->add('filename')
            ->add('mimeType')
        ;
    }

    public function create($object)
    {
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine_mongodb')->getManager();

        $upload = $object->getFile();
        // GridFS want a path to the file
        $object->setFile($upload->getPathName());
        $object->setFilename($upload->getClientOriginalName());
        $object->setMimeType($upload->getMimeType());
        
        $dm->persist($object);
        $dm->flush();
    }
}
