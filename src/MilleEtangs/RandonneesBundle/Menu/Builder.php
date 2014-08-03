<?php

namespace MilleEtangs\RandonneesBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('main');
        $menu->setUri($this->container->get('request')->getRequestUri());

        $menu->addChild('Accueil', array('route' => 'home'));
        $menu->addChild('Actualités', array('route' => 'articles'));
        $menu->addChild('Randonnées', array('route' => 'itinearies'));
        $menu->addChild('Les Mille Étangs', array('route' => 'mille_etangs'));

        return $menu;
    }
}
