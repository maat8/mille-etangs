<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArticlesController extends Controller
{
    public function articlesAction()
    {
        $articles = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(10);

        return $this->render('MilleEtangsRandonneesBundle:Default:articles.html.twig', array(
            'articles' => $articles
        ));
    }

    public function rssAction()
    {
        $body = $this->renderView("MilleEtangsRandonneesBundle:Default:rss.xml.twig", array());

        $response = new Response($body);
        $response->headers->set('Content-Type', "application/rss+xml");
        
        return $response;
    }
}
