<?php

namespace MilleEtangs\RandonneesBundle\Twig;

class ItinearyExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('distance', array($this, 'distanceFilter')),
            new \Twig_SimpleFilter('incline', array($this, 'inclineFilter')),
            new \Twig_SimpleFilter('difficulty', array($this, 'difficultyFilter')),
        );
    }

    public function distanceFilter($number)
    {
        $distance = round(($number / 1000), 1) . " km";

        return $distance;
    }

    public function inclineFilter($number)
    {
        $incline = $number . " m";

        return $incline;
    }

    public function difficultyFilter($number)
    {
        $difficulties = array(
            1 => "Facile",
            2 => "Moyen",
            3 => "Difficile",
        );

        $difficulty = (array_key_exists($number, $difficulties)) ? $difficulties[$number] : "";

        return $difficulty;
    }

    public function getName()
    {
        return 'itineary_extension';
    }
}
