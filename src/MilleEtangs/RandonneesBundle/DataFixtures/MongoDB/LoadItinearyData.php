<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use MilleEtangs\RandonneesBundle\Document\Itineary;

class LoadItinearyData implements FixtureInterface, ContainerAwareInterface
{
    protected $container;

    public function load(ObjectManager $manager)
    {
        $itineary = new Itineary();
        $itineary->setName('Circuit de la mer');
        $itineary->setTeaser(
            'Découvrez les Mille Etangs en parcourant le plateau depuis le village de La Mer.'
        );
        $itineary->setAccess('A partir de Faucogney, prenez ...');
        $itineary->setBikeLength(120);
        $itineary->setDistance(17000);
        $itineary->setPublished(true);

        $file = new UploadedFile(
            "src/MilleEtangs/RandonneesBundle/Resources/tests/Plateau_des_Grilloux.gpx",
            "Plateau_des_Grilloux.gpx"
        );

        $traceConverter = $this->container->get('trace_converter');
        $traceConverter->generateTracesFromFile($file);
        $itineary->setGpx($traceConverter->getGpx());
        $itineary->setKml($traceConverter->getKml());

        $manager->persist($itineary);
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
