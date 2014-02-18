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

    public function itineariesAction($type = null)
    {
        $repository = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary');

        switch($type){
            case "vtt":
                $itinearies = $repository->findAllByType("bike");
                break;
            case "marche":
                $itinearies = $repository->findAllByType("hike");
                break;
            default:
                $itinearies = $repository->findAll();
        }

        return $this->render("MilleEtangsRandonneesBundle:Default:itinearies.html.twig", array(
            'itinearies' => $itinearies
        ));
    }

    public function itinearyAction($slug)
    {
        $itineary = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findOneBySlug($slug);

        return $this->render('MilleEtangsRandonneesBundle:Default:itineary.html.twig', array(
            'itineary' => $itineary
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

    public function renderImageAction($id = null)
    {
        if (!is_null($id)) {
            $image = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Image')
                ->findOneById($id);

            if (!is_null($image)) {
                $response = new Response();
                $response->headers->set('Content-Type', $image->getMimeType());
                $response->setContent($image->getFile()->getBytes());
                
                return $response;
            }
        }

        return new Response('Not Found', 404);
    }

    public function downloadGpxAction($id = null)
    {
        if (!is_null($id)) {
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Itineary')
                ->findOneById($id);

            if (!is_null($itineary)) {
                $response = new Response();
                $response->headers->set('Content-Type', "application/gpx+xml");
                $response->headers->set('Content-Disposition', 'attachment; filename="'.$itineary->getName().'.gpx"');
                $response->sendHeaders();
                $response->setContent($itineary->getGpx()->getBytes());

                return $response;
            }
        }

        return new Response('Not Found', 404);
    }

    public function renderKmlAction($id = null)
    {
        if (!is_null($id)) {
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Itineary')
                ->findOneById($id);

            if (!is_null($itineary)) {
                $response = new Response();
                $response->headers->set('Content-Type', "application/vnd.google-earth.kml+xml");
                $response->setContent($itineary->getKml()->getBytes());
                
                return $response;
            }
        }

        return new Response('Not Found', 404);
    }
}
