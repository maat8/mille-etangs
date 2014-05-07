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

        return $this->render('MilleEtangsRandonneesBundle:Articles:articles.html.twig', array(
            'articles' => $articles
        ));
    }

    public function articleAction($slug)
    {
        $article = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findOneBySlug($slug);

        return $this->render('MilleEtangsRandonneesBundle:Articles:article.html.twig', array(
            'article' => $article
        ));
    }

    public function rssAction()
    {
        $articles = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(10);

        $body = $this->renderView("MilleEtangsRandonneesBundle:Articles:rss.xml.twig", array(
            'articles' => $articles
        ));

        return new Response($body, 200, array('Content-Type' => 'application/rss+xml; charset=utf-8'));
    }
}
