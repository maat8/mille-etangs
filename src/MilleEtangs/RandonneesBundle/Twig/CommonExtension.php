<?php

namespace MilleEtangs\RandonneesBundle\Twig;

class CommonExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('html', array($this, 'html'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('displayBoolean', array($this, 'displayBoolean'))
        );
    }

    public function html($string)
    {
        return strip_tags($string, "<br><a><p><ul><li><strong><small><i>");
    }

    public function getName()
    {
        return 'common_extension';
    }

    public function displayBoolean($boolean)
    {
        return ($boolean) ? "Oui" : "Non";
    }
}
