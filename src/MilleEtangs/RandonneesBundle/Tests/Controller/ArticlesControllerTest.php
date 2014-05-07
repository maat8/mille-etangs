<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticlesControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testArticles()
    {
        $crawler = $this->client->request('GET', $this->router->generate('articles'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Actualités")')->count() > 0);
    }

    public function testRss()
    {
        $crawler = $this->client->request('GET', $this->router->generate('rss'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'application/rss+xml; charset=utf-8'));
    }
}
