<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MilleEtangs\RandonneesBundle\Entity\Categorie;

class LoadCategoriesData implements FixtureInterface
{
	public function load(ObjectManager $manager)
    {
        $divers = new Categorie();
        $divers->setNom('Parcours');
        $manager->persist($divers);
        $manager->flush();

        $divers = new Categorie();
        $divers->setNom('Événement');
        $manager->persist($divers);
        $manager->flush();

        $divers = new Categorie();
        $divers->setNom('Divers');
        $manager->persist($divers);
        $manager->flush();
    }
}