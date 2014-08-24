<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use MilleEtangs\RandonneesBundle\Document\Itineary;
use MilleEtangs\RandonneesBundle\Document\Trace;

class LoadItinearyData implements FixtureInterface
{
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

        $manager->persist($itineary);
        $manager->flush();
    }
}
