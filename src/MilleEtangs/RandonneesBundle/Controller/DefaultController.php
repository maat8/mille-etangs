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
        $itinearies = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllByType($type);

    	return $this->render("MilleEtangsRandonneesBundle:Default:itinearies_{$type}.html.twig", array(
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

    public function sitemapAction($_format = null){
        $randonneesVtt = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllVtt();

        $randonneesMarche = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAllMarche();

        $format = $_format ?: "html";
        return $this->render("MilleEtangsRandonneesBundle:Default:sitemap.{$format}.twig", array(
            'randonneesVtt' => $randonneesVtt,
            'randonneesCheval' => $randonneesCheval,
            'randonneesMarche' => $randonneesMarche
        ));
    }

    public function rssAction(){
        return $this->render("MilleEtangsRandonneesBundle:Default:rss.html.twig", array(
        ));
    }
}
