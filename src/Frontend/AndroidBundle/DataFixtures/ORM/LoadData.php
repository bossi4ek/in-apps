<?php

namespace Frontend\FilmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Frontend\AndroidBundle\Entity\Developer;
use Frontend\AndroidBundle\Entity\Category;
use Frontend\AndroidBundle\Entity\Content;

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
            copy($source."/".$i.".png", $destination."/".$i.".png");
        }
        copy($source."/not_img.jpg", $destination."/not_img.jpg");
    }

//======================================================================================================================
    public function loadDeveloper(ObjectManager $manager)
    {
        $name = 'Тест1';
        $dev1 = new Developer();
        $dev1->setName($name);
        $dev1->setIsPublish(1);
        $manager->persist($dev1);

        $name = 'Тест2';
        $dev2 = new Developer();
        $dev2->setName($name);
        $dev2->setIsPublish(1);
        $manager->persist($dev2);

        $manager->flush();
    }

//======================================================================================================================
    public function loadCategory(ObjectManager $manager)
    {
        $name = 'Игры';
        $category1 = new Category();
        $category1->setName($name);
        $category1->setIsPublish(1);
        $manager->persist($category1);

        $name = 'Бизнес';
        $category2 = new Category();
        $category2->setName($name);
        $category2->setIsPublish(1);
        $manager->persist($category2);

        $name = 'Виджеты';
        $category3 = new Category();
        $category3->setName($name);
        $category3->setIsPublish(1);
        $manager->persist($category3);

        $name = 'Медицина';
        $category4 = new Category();
        $category4->setName($name);
        $category4->setIsPublish(1);
        $manager->persist($category4);

        $manager->flush();
    }

//======================================================================================================================
    public function loadContent(ObjectManager $manager)
    {
        $categoryRepository = $manager->getRepository('FrontendAndroidBundle:Category');
        $developerRepository = $manager->getRepository('FrontendAndroidBundle:Developer');

        $name = 'BADLAND';
        $description = 'BADLAND - этот великолепный платформер наконец-то добрался с iOS до нашей операционной системы. Игра была отмечена наградами за лучший дизайн и инновационный геймплей. Если вы ищете что-то классное и интересное, то это именно оно, игра затягивает сразу и надолго. На наш взгляд, это одна из лучших игр для Android.';
        $content1 = new Content();
        $content1->setName($name);
        $content1->setPosterImg("1.png");
        $content1->setDescription($description);
        $content1->addCategory($categoryRepository->findOneBy(array('id' => '1')));
        $content1->addDeveloper($developerRepository->findOneBy(array('id' => '1')));
        $content1->setSize("1000");
        $content1->setVersion("1.0");
        $content1->setYear(2013);
        $content1->setInstallCount(22);
        $content1->setViewCount(0);

        $content1->setIsPublish(1);

        $manager->persist($content1);


        $name = 'Can Knockdown 3';
        $description = 'Can Knockdown 3 - это потрясающая во всех планах игра, в которой мы будем сбивать с помощью мячиков стоящие банки. Великолепная 3D-графика, качественная физика, большое количество уровней, и все это полностью бесплатно. Одна из лучших игр для Android';
        $content2 = new Content();
        $content2->setName($name);
        $content2->setPosterImg("2.png");
        $content2->setDescription($description);
        $content2->addCategory($categoryRepository->findOneBy(array('id' => '2')));
        $content2->addCategory($categoryRepository->findOneBy(array('id' => '3')));
        $content2->addDeveloper($developerRepository->findOneBy(array('id' => '2')));
        $content2->setSize("2000");
        $content2->setVersion("1.2");
        $content2->setYear(2014);
        $content2->setInstallCount(500);
        $content2->setViewCount(0);

        $content2->setIsPublish(1);

        $manager->persist($content2);


        $name = 'Gravity Maze';
        $description = 'Gravity Maze - это забавная физическая аркада-головоломка, в которой мы должны помочь отряду инопланетян выбраться из лабиринта. Управляется игра с помощью акселерометра и напоминает старые пластмассовые игрушки-лабиринты с железными шариками.';
        $content3 = new Content();
        $content3->setName($name);
        $content3->setPosterImg("3.png");
        $content3->setDescription($description);
        $content3->addCategory($categoryRepository->findOneBy(array('id' => '1')));
        $content3->addCategory($categoryRepository->findOneBy(array('id' => '3')));
        $content3->addDeveloper($developerRepository->findOneBy(array('id' => '1')));
        $content3->setSize("4000");
        $content3->setVersion("2");
        $content3->setYear(2014);
        $content3->setInstallCount(10);
        $content3->setViewCount(0);

        $content3->setIsPublish(1);

        $manager->persist($content3);

        $name = 'Hungry Shark Evolution';
        $description = 'Hungry Shark Evolution - это бесплатная игра в жанре экшен, где мы возьмем на себя роль кровожадной акулы, поедающей обитателей океана и живых людей, приехавших на отдых. Игра порадовала нас качественной графикой, обилием крови и простым управлением.';
        $content4 = new Content();
        $content4->setName($name);
        $content4->setPosterImg("4.png");
        $content4->setDescription($description);
        $content4->addCategory($categoryRepository->findOneBy(array('id' => '3')));
        $content4->addDeveloper($developerRepository->findOneBy(array('id' => '2')));
        $content4->setSize("500");
        $content4->setVersion("2.3");
        $content4->setYear(2013);
        $content4->setInstallCount(10000);
        $content4->setViewCount(0);

        $content4->setIsPublish(1);

        $manager->persist($content4);


        $manager->flush();
    }

//======================================================================================================================
    public function loadUser()
    {
        $userManager = $this->container->get('fos_user.user_manager');

        // Create Admin
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('admin@gmail.com');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user, true);

        // Create user
        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@gmail.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        $userManager->updateUser($user, true);
    }

    public function load(ObjectManager $manager)
    {
        $this->copyImg();

        $this->loadDeveloper($manager);
        $this->loadCategory($manager);
        $this->loadContent($manager);
        $this->loadUser();
    }
}