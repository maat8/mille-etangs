<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        $articles = $this->get('doctrine_mongodb')->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(3);

        return array(
            'articles' => $articles
        );
    }

    public function renderImageAction($id = null)
    {
        if (!is_null($id)) {
            $image = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Image')
                ->findOneById($id);

            if (!is_null($image)) {
                // TODO use BinaryFileResponse
                $response = new Response();
                $response->headers->set('Content-Type', $image->getMimeType());
                $response->setContent($image->getFile()->getBytes());

                return $response;
            }
        }

        throw $this->createNotFoundException("Le fichier n'existe pas");
    }

    /**
     * @Template
     */
    public function eventsAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function accomodationsAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function restaurantsAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function milleEtangsAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function partnersAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function adviceAction()
    {
        return array();
    }

    /**
     * @Template
     */
    public function legalAction()
    {
        return array();
    }
}
