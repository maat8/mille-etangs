<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Template
     * @Cache(expires="1 hour")
     */
    public function indexAction()
    {
        $articles = $this->get('doctrine_mongodb')->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findLastPublishedArticles(3);

        return array(
            'articles' => $articles
        );
    }

    /**
     * @Cache(expires="tomorrow")
     */
    public function renderImageAction($id = null)
    {
        if (!is_null($id)) {
            $image = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Image')
                ->findOneById($id);

            if (!is_null($image)) {
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
    public function partnersAction()
    {
        return array();
    }
}
