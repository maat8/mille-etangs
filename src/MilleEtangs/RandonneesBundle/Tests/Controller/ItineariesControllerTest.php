<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItineariesControllerTest extends WebTestCase
{
    private $client;
    private $router;

    protected $itineary = "le-tour-de-la-mer";

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
        $this->client->request('GET', $this->router->generate(
            'itineary',
            array('slug' => $this->itineary)
        ));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testItinearyGpx()
    {
        ob_start();

        // Success
        $crawler = $this->client->request('GET', $this->router->generate(
            'download_gpx',
            array('slug' => $this->itineary)
        ));
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        // No file must return a 404
        $this->client->request('GET', $url = $this->router->generate(
            'download_gpx',
            array('slug' => 1)
        ));

        $this->assertFalse($this->client->getResponse()->isSuccessful());

        ob_end_clean();
    }

    public function testItinearyKml()
    {
        ob_start();

        // Success
        $crawler = $this->client->request('GET', $this->router->generate(
            'render_kml',
            array('slug' => $this->itineary)
        ));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals($crawler->filter('kml')->count(), 1);

        // No file must return a 404
        $this->client->request('GET', $this->router->generate(
            'render_kml',
            array('slug' =>1)
        ));
        $this->assertFalse($this->client->getResponse()->isSuccessful());

        ob_end_clean();
    }
}
