<?php

namespace MilleEtangs\RandonneesBundle\Twig;

class ItinearyExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('distance', array($this, 'distanceFilter')),
            new \Twig_SimpleFilter('incline', array($this, 'inclineFilter')),
            new \Twig_SimpleFilter('difficulty', array($this, 'difficultyFilter'))
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

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('generateCssClass', array($this, 'generateCssClass'))
        );
    }

    public function generateCssClass($itineary)
    {
        $classes = array();

        if ($itineary->getMarked()) {
            $classes[] = "itineary-marked";
        }

        if ($itineary->getMountainBikeLength() > 0) {
            $classes[] = "itineary-mountainbike";
        }

        if ($itineary->getRoadBikeLength() > 0) {
            $classes[] = "itineary-roadbike";
        }

        if ($itineary->getHikeLength() > 0) {
            $classes[] = "itineary-hike";
        }

        return implode(" ", $classes);
    }

    public function getName()
    {
        return 'itineary_extension';
    }
}
