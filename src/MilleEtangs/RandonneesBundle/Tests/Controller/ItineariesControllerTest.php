<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItineariesControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testItinearies()
    {
        $crawler = $this->client->request('GET', '/randonnees');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Randonnées")')->count() > 0);
    }

    public function testItineary()
    {
        $crawler = $this->client->request('GET', '/randonnee/circuit-de-la-mer');

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        //$gpx_uri = $crawler->filter(".gpx")->link()->getUri();
    }
}