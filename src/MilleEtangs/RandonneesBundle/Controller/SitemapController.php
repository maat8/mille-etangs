<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    
    public function sitemapAction($_format = null)
    {
        $itineariesBike = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllBike();

        $itineariesHike = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllHike();

        $format = $_format ?: "html";
        $body = $this->renderView("MilleEtangsRandonneesBundle:Sitemap:sitemap.{$format}.twig", array(
            'itineariesHike' => $itineariesHike,
            'itineariesBike' => $itineariesBike
        ));

        $response = new Response($body);
        if ($format == "xml") {
            $response->headers->set('Content-Type', "text/xml");
        }

        return $response;
    }
}
