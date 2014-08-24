<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

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

        $crawler = $this->client->request('GET', $this->router->generate('itinearies', array('type' => "vtt")));
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
    }

    public function testItinearyGpx()
    {
        ob_start();
        $crawler = $this->client->request('GET', $route = $this->router->generate(
            'download_gpx',
            array('slug' => "circuit-de-la-mer")
        ));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals($crawler->filter('gpx')->count(), 1);

        $crawler = $this->client->request('GET', $route = $this->router->generate(
            'download_gpx',
            array('slug' => 1)
        ));
        $this->assertFalse($this->client->getResponse()->isSuccessful());
        $this->assertEquals($this->client->getResponse()->getStatusCode(), 404);
        ob_end_clean();
    }

    public function testItinearyKml()
    {
        ob_start();
        $crawler = $this->client->request('GET', $route = $this->router->generate(
            'render_kml',
            array('slug' => "circuit-de-la-mer")
        ));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals($crawler->filter('kml')->count(), 1);

        $crawler = $this->client->request('GET', $route = $this->router->generate(
            'render_kml',
            array('slug' => 1)
        ));
        $this->assertFalse($this->client->getResponse()->isSuccessful());
        $this->assertEquals($this->client->getResponse()->getStatusCode(), 404);
        ob_end_clean();
    }
}
