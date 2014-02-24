<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use MilleEtangs\RandonneesBundle\Entity\Parcours;
use MilleEtangs\RandonneesBundle\Entity\Actualite;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $articles = $this->get('doctrine_mongodb')->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(1);

        return $this->render('MilleEtangsRandonneesBundle:Default:index.html.twig', array(
            'articles' => $articles
        ));
    }

    public function articlesAction()
    {
        $articles = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(10);

        return $this->render('MilleEtangsRandonneesBundle:Default:articles.html.twig', array(
            'articles' => $articles
        ));
    }

    public function eventsAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:events.html.twig');
    }

    public function accomodationsAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:accomodations.html.twig');
    }

    public function restaurantsAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:restaurants.html.twig');
    }

    public function milleEtangsAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:mille_etangs.html.twig');
    }

    public function partnersAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:partners.html.twig');
    }

    public function adviceAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:advice.html.twig');
    }

    public function legalAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:legal.html.twig');
    }

    public function sitemapAction($_format = null)
    {
        $itineariesBike = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllBike();

        $itineariesHike = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllHike();

        $format = $_format ?: "html";
        $body = $this->renderView("MilleEtangsRandonneesBundle:Default:sitemap.{$format}.twig", array(
            'itineariesHike' => $itineariesHike,
            'itineariesBike' => $itineariesBike
        ));

        $response = new Response($body);
        if ($format == "xml") {
            $response->headers->set('Content-Type', "text/xml");
        }

        return $response;
    }

    public function rssAction()
    {
        $body = $this->renderView("MilleEtangsRandonneesBundle:Default:rss.xml.twig", array());

        $response = new Response($body);
        $response->headers->set('Content-Type', "application/rss+xml");
        
        return $response;
    }
}
