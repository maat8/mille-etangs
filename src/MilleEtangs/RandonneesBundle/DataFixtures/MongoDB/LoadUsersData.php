<?php

namespace MilleEtangs\RandonneesBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

use MilleEtangs\RandonneesBundle\Document\User;

class LoadUsersData extends ContainerAware implements FixtureInterface
{
    protected $container;

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername("admin");
        $this->setPassword($admin, "coco");

        $manager->persist($admin);
        $manager->flush();
    }

    protected function setPassword(User $user, $password)
    {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($password, $user->regenerateSalt());
        $user->setPassword($password);
    }
}
