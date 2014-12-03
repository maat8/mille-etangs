<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use MilleEtangs\RandonneesBundle\Document\Itineary;

class LoadItinearyData extends ContainerAware implements FixtureInterface
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
        $itineary->setMountainBikeLength(120);
        $itineary->setMountainBikeLength(240);
        $itineary->setDistance(17000);
        $itineary->setMarked(true);
        $itineary->setDifficulty(1);
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

        $itineary = new Itineary();
        $itineary->setName('Le plateau des grilloux');
        $itineary->setMountainBikeLength(60);
        $itineary->setDistance(11000);
        $itineary->setDifficulty(2);
        $itineary->setPublished(true);

        $manager->persist($itineary);
        $manager->flush();
    }
}
