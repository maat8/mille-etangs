<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use MilleEtangs\RandonneesBundle\Entity\Parcours;

class LoadParcoursData implements FixtureInterface
{
	public function load(ObjectManager $manager)
    {
        $parcours = new Parcours();
        $parcours->setNom('Parcours');
        $parcours->setTeaser('Une magnifique balade blabla');
        $parcours->setAcces('A partir de Servance, prenez ...');
        $parcours->setDureeVtt(120);
        $parcours->setDistance(17000);
        $parcours->setPublie(true);

        $manager->persist($parcours);
        $manager->flush();
    }
}