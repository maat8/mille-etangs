<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use MilleEtangs\RandonneesBundle\Document\Article;

class LoadArticleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setName('Mille pas aux Mille Etangs');
        $article->setContent(
            "La 12ème édition des randonnées Mille pas aux Mille étangs se dérouleront du 27 avril au 22 juin 2014
            dans les villages de la Vallée du Breuchin, de Servance et de Saint Bresson.
            Pour chaque événement, deux parcours seront proposés : un petit de 8 à 10 km et un autre de 16 à 20 km.
            <ul>
                <li>dimanche 27 avril au départ de Servance</li>
                <li>jeudi 1er mai au départ de Amage</li>
                <li>dimanche 4 mai au départ de Beulotte St Laurent</li>
                <li>jeudi 8 mai au départ de Corravillers</li>
                <li>dimanche 11 mai au départ de Sainte Marie en Chanois</li>
                <li>dimanche 18 mai au départ de Faucogney</li>
                <li>jeudi 29 mai au départ de Raddon et Chapendu</li>
                <li>dimanche 1er juin au départ d'Ecromagny</li>
                <li>dimanche 8 juin au départ d'Esmoulières</li>
                <li>samedi 14 juin au départ de Saint Bresson (randonnée nocturne)</li>
                <li>dimanche 15 juin au départ de la Rosière</li>
                <li>dimanche 22 juin au départ de la Bruyère</li>
            </ul>
            Pour d'autres informations, vous pouvez contacter
            l'<a href='http://www.ot-faucogney.fr/' target='_blank'>Office de Tourisme de Faucogney</a>"
        );

        $manager->persist($article);
        $manager->flush();
    }
}
