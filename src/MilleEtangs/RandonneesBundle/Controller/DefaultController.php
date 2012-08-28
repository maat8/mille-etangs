<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MilleEtangs\RandonneesBundle\Entity\Randonnee;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MilleEtangsRandonneesBundle:Default:index.html.twig');
    }

    public function randonneesAction()
    {
        /*$rando = new Randonnee();
        $rando->setName("Peugeux");
        $rando->setSlug("peugeux");
        $rando->setDureeVtt(120);
        $rando->setDescription("Autour de Saint Bresson...");
        $rando->setEndomondoLink("http://www.endomondo.com/tracks/146");

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($rando);
        $em->flush();*/

        $randonnees = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Randonnee')
            ->findAll();

    	return $this->render('MilleEtangsRandonneesBundle:Default:randonnees.html.twig', array(
            'randonnees' => $randonnees
        ));	
    }

    public function randonneeAction($slug)
    {
        $randonnee = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Randonnee')
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
}
