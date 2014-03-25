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

    public function testMilleEtangs()
    {
        $crawler = $this->client->request('GET', '/les-mille-etangs');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Les Mille Étangs")')->count() > 0);
    }
}
