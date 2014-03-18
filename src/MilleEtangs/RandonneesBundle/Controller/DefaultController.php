<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
