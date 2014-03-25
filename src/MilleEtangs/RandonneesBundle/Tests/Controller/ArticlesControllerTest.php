<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticlesControllerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testRss()
    {
        $crawler = $this->client->request('GET', '/rss.xml');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'application/rss+xml'));
    }
}
