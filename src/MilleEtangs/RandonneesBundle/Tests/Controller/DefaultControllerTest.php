<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testIndex()
    {
        $crawler = $this->client->request('GET', $this->router->generate('home'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Mille Étangs")')->count() > 0);
    }

    public function testRenderImage()
    {
        $crawler = $this->client->request('GET', $this->router->generate('render_image', array('id' => null)));

        $this->assertFalse($this->client->getResponse()->isSuccessful());
        $this->assertEquals($this->client->getResponse()->getStatusCode(), 404);
    }

    public function testMilleEtangs()
    {
        $crawler = $this->client->request('GET', $this->router->generate('mille_etangs'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Les Mille Étangs")')->count() > 0);
    }

    public function testEvents()
    {
        $crawler = $this->client->request('GET', $this->router->generate('events'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testAccomodations()
    {
        $crawler = $this->client->request('GET', $this->router->generate('accomodations'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testRestaurants()
    {
        $crawler = $this->client->request('GET', $this->router->generate('restaurants'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testPartners()
    {
        $crawler = $this->client->request('GET', $this->router->generate('partners'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testAdvice()
    {
        $crawler = $this->client->request('GET', $this->router->generate('advice'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testLegal()
    {
        $crawler = $this->client->request('GET', $this->router->generate('legal'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
