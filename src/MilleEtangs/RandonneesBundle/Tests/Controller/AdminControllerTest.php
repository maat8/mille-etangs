<?php

namespace MilleEtangs\RandonneesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminControllerTest extends WebTestCase
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

    public function testDashboard()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', $this->router->generate('sonata_admin_dashboard'));

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Article")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Itinéraire")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Ajouter")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Liste")')->count());
    }

    public function testCreateItineary()
    {
        $this->logIn();
        $crawler = $this->client->request(
            'GET',
            $this->router->generate('admin_milleetangs_randonnees_itineary_create')
        );

        $kernel = $this->client->getKernel();
        $path = $kernel->locateResource('@MilleEtangsRandonneesBundle/Resources/tests/Plateau_des_Grilloux.gpx');

        $gpx = new UploadedFile(
            $path,
            "Plateau_des_Grilloux.gpx"
        );

        $itineary_name = "Test" . uniqid();
        $form = $crawler->selectButton('btn_create_and_list')->form();

        $uniqid = end(explode("=", $form->getUri()));

        $form->setValues(array(
            "{$uniqid}[name]" => $itineary_name,
            "{$uniqid}[description]" => "Description",
            "{$uniqid}[gpx]" => $gpx
        ));

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("'.$itineary_name.'")')->count());

        $link = $crawler->selectLink("{$itineary_name}")->link();
        $this->client->click($link);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
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
