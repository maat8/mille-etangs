<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItineariesControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }
    
    public function testItinearies()
    {
        $crawler = $this->client->request('GET', $this->router->generate('itinearies'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Randonnées")')->count() > 0);
    }

    public function testItineary()
    {
        $crawler = $this->client->request('GET', $route = $this->router->generate(
            'itineary',
            array('slug' => "circuit-de-la-mer")
        ));

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        //$gpx_uri = $crawler->filter(".gpx")->link()->getUri();
        // TODO : check gpx & kml
    }
}
