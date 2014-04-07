<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MilleEtangs\RandonneesBundle\Document\Comment;

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

        $comment = new Comment();
        $form_comment =  $this->get('form.factory')->create("comment", $comment);

        return $this->render('MilleEtangsRandonneesBundle:Itinearies:itineary.html.twig', array(
            'itineary' => $itineary,
            'form_comment' => $form_comment->createView()
        ));
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
