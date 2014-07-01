<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MilleEtangs\RandonneesBundle\Document\Trace;

class ItineariesController extends Controller
{
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

        return $this->render("MilleEtangsRandonneesBundle:Itinearies:itinearies.html.twig", array(
            'itinearies' => $itinearies
        ));
    }

    public function itinearyAction($slug)
    {
        $itineary = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findOneBySlug($slug);

        if (is_null($itineary)) {
            throw $this->createNotFoundException('Cet itinéraire n\'existe pas');
        }

        return $this->render('MilleEtangsRandonneesBundle:Itinearies:itineary.html.twig', array(
            'itineary' => $itineary
        ));
    }

    public function downloadGpxAction($slug = null)
    {
        if (!is_null($slug)) {
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Itineary')
                ->findOneBySlug($slug);

            if (!is_null($itineary)) {
                $response = new Response();
                $response->headers->set('Content-Type', "application/gpx+xml");
                $filename = $itineary->getName().'.gpx';
                $response->headers->set('Content-Disposition', "attachment;filename=\"{$filename}\"");
                $response->setContent($itineary->getGpx()->getFile()->getBytes());
                $response->send();

                return $response;
            }
        }

        // return new Response('Not Found', 404);
    }

    public function renderKmlAction($slug = null)
    {
        if (!is_null($slug)) {
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Itineary')
                ->findOneBySlug($slug);

            if (!is_null($itineary)) {
                $response = new Response();
                $response->headers->set('Content-Type', "application/vnd.google-earth.kml+xml");
                $response->setContent($itineary->getKml()->getFile()->getBytes());
                
                return $response;
            }
        }

        return new Response('Not Found', 404);
    }
}
