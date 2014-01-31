<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Mille Étangs")')->count() > 0);
    }

    public function testItinearies()
    {
        $crawler = $this->client->request('GET', '/randonnees');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Randonnées")')->count() > 0);
    }

    public function testMilleEtangs()
    {
        $crawler = $this->client->request('GET', '/les-mille-etangs');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Les Mille Étangs")')->count() > 0);
    }

    public function testItineary()
    {
        $crawler = $this->client->request('GET', '/randonnee/circuit-de-la-mer');

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $gpx_uri = $crawler->filter(".gpx")->link()->getUri();
    }

    public function testRss()
    {
        $crawler = $this->client->request('GET', '/rss.xml');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'application/rss+xml'));
    }

    public function testSitemap()
    {
        $crawler = $this->client->request('GET', '/sitemap.xml');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'text/xml; charset=UTF-8'));
        $this->assertTrue($crawler->filterXpath("//urlset")->count() > 0);
    }
}
