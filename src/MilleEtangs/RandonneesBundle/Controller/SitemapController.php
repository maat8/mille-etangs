<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{

    public function sitemapAction($_format = null)
    {
        $itinearies = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAll();

        $articles = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(1);

        $format = $_format ?: "html";
        $body = $this->renderView("MilleEtangsRandonneesBundle:Sitemap:sitemap.{$format}.twig", array(
            'itinearies' => $itinearies,
            'article' => $articles->getNext()
        ));

        $response = new Response($body);
        if ($format == "xml") {
            $response->headers->set('Content-Type', "text/xml");
        }

        return $response;
    }
}
