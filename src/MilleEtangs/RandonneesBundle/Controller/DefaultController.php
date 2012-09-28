<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use MilleEtangs\RandonneesBundle\Entity\Parcours;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:index.html.twig', array(
            'actualites' => $this->get('doctrine')->getRepository('MilleEtangsRandonneesBundle:Actualite')->findAllActualitesPubliees()
        ));
    }

    public function randonneesAction($type = null)
    {
        $randonnees = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Parcours')
            ->findAllVtt();

    	return $this->render("MilleEtangsRandonneesBundle:Default:randonnees_{$type}.html.twig", array(
            'randonnees' => $randonnees
        ));	
    }

    public function randonneeAction($slug)
    {
        $randonnee = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Parcours')
            ->findOneBySlug($slug);        

    	return $this->render('MilleEtangsRandonneesBundle:Default:randonnee.html.twig', array(
            'randonnee' => $randonnee
        ));	
    }

    public function evenementsAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:evenements.html.twig');
    }

    public function hebergementAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:hebergement.html.twig');
    }

    public function restaurationAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:restauration.html.twig');
    }

    public function milleEtangsAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:mille_etangs.html.twig');
    }

    public function partenairesAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:partenaires.html.twig');
    }

    public function sitemapAction($_format = null){
        // Pages statiques

        // Pages dynamiques : parcours, actualités, catégories

        $format = $_format ?: "html";
        return $this->render("MilleEtangsRandonneesBundle:Default:sitemap.{$format}.twig");
    }
}
