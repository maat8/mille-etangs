<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecurityControllerTest extends WebTestCase
{
    private $client;
    private $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }

    public function testLogIn()
    {
        $crawler = $this->client->request('GET', $this->router->generate('login'));

        $form = $crawler->selectButton('login')->form(array(
            '_username' => "admin",
            '_password' => "coco",
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testMenu()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $this->router->generate('admin_menu'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Administation")')->count());
    }

    public function testCreateItineary()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $this->router->generate('create_itineary'));

        $kernel = $this->client->getKernel();
        $path = $kernel->locateResource('@MilleEtangsRandonneesBundle/Resources/tests/Plateau_des_Grilloux.gpx');

        $gpx = new UploadedFile(
            $path,
            "Plateau_des_Grilloux.gpx"
        );

        $itineary_name = "Test" . uniqid();
        $form = $crawler->selectButton('save')->form(array(
            'itineary[name]' => $itineary_name,
            'itineary[gpx]' => $gpx
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('div.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Randonnée Test 0")')->count());

        $link = $crawler->selectLink("{$itineary_name}")->link();
        $client->click($link);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('div.alert-success')->count());
    }

    public function testCreateArticle()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $this->router->generate('create_article'));
        $form = $crawler->selectButton('save')->form(array(
            'article[name]' => "Article Test 0"
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('div.alert-success')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Article Test 0")')->count());
    }

    public function testUploadImage()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $this->router->generate('upload_image'));

        // TODO
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'secured_area';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
