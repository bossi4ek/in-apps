<?php

namespace Frontend\FilmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFilmsData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 10;
    }

    public function copyImg()
    {
        $source = __DIR__.'/img';
        $destination = __DIR__.'/../../../../../web/uploads/poster';

        for ($i = 1; $i <= 4; $i++) {
            copy($source."/".$i.".jpg", $destination."/".$i.".jpg");
        }
        copy($source."/not_img.jpg", $destination."/not_img.jpg");
    }

    public function load(ObjectManager $manager)
    {
        echo "OK";
    }
}