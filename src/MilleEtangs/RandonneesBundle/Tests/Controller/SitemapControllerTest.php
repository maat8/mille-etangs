<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SitemapControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testSitemap()
    {
        $crawler = $this->client->request('GET', '/sitemap.xml');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($this->client->getResponse()->headers->contains('Content-Type', 'text/xml; charset=UTF-8'));
        $this->assertTrue($crawler->filterXpath("//urlset")->count() > 0);
    }
}
