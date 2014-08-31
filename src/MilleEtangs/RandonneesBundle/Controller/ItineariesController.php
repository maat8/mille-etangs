<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ItineariesController extends Controller
{
    /**
     * @Template
     */
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

        return array(
            'itinearies' => $itinearies
        );
    }

    /**
     * @Template
     */
    public function itinearyAction($slug)
    {
        $itineary = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findOneBySlug($slug);

        if (is_null($itineary)) {
            throw $this->createNotFoundException('Cet itinéraire n\'existe pas');
        }

        return array(
            'itineary' => $itineary
        );
    }

    public function downloadGpxAction($slug = null)
    {
        if (!is_null($slug)) {
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Itineary')
                ->findOneBySlug($slug);

            if (!is_null($itineary) && !is_null($itineary->getGpx())) {
                $response = new Response();
                $response->headers->set('Content-Type', "application/gpx+xml");
                $filename = $itineary->getName().'.gpx';
                $response->headers->set('Content-Disposition', "attachment;filename=\"{$filename}\"");
                $response->setContent($itineary->getGpx()->getFile()->getBytes());
                $response->send();

                return $response;
            }
        }

        throw $this->createNotFoundException("Le fichier n'existe pas");
    }

    public function renderKmlAction($slug = null)
    {
        if (!is_null($slug)) {
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Itineary')
                ->findOneBySlug($slug);

            if (!is_null($itineary) && !is_null($itineary->getKml())) {
                $response = new Response();
                $response->headers->set('Content-Type', "application/vnd.google-earth.kml+xml");
                $response->setContent($itineary->getKml()->getFile()->getBytes());

                return $response;
            }
        }

        throw $this->createNotFoundException("Le fichier n'existe pas");
    }
}
