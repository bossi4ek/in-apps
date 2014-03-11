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
            copy($source."/".$i.".jpg", $destination."/".$i.".jpg");
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

        $name = 'Капитан Филлипс';
        $description = 'В начале апреля 2009 года, близ берегов Африки, несколько сомалийских пиратов атакуют и пытаются захватить массивный контейнеровоз MV Maersk Alabama. Команда корабля активно сопротивляется и в конце концов не даёт взять себя в плен. Захватчики вынуждены ретироваться и покинуть судно на небольшом катере, прихватив с собой немолодого капитана Ричарда Филлипса...';
        $content1 = new Content();
        $content1->setName($name);
        $content1->setPosterImg("1.jpg");
        $content1->setDescription($description);
        $content1->addCategory($categoryRepository->findOneBy(array('id' => '1')));
        $content1->addDeveloper($developerRepository->findOneBy(array('id' => '1')));
        $content1->setSize(1000);
        $content1->setVersion("1.0");
        $content1->setYear(2013);
        $content1->setInstallCount(22);

        $content1->setIsPublish(1);

        $manager->persist($content1);


        $name = 'Два ствола';
        $description = 'Это история двух грабителей, которые на самом деле не те, кем кажутся. Один из них — агент из управления по борьбе с наркотиками, а другой — тайный агент разведки ВМС. Сами того не желая, они занимаются расследованием дел друг друга, а также воруют деньги у мафии. Через некоторое время героям придется украсть 50 миллионов долларов у ЦРУ.';
        $content2 = new Content();
        $content2->setName($name);
        $content2->setPosterImg("2.jpg");
        $content2->setDescription($description);
        $content2->addCategory($categoryRepository->findOneBy(array('id' => '2')));
        $content2->addCategory($categoryRepository->findOneBy(array('id' => '3')));
        $content2->addDeveloper($developerRepository->findOneBy(array('id' => '2')));
        $content2->setSize(2000);
        $content2->setVersion("1.2");
        $content2->setYear(2014);
        $content2->setInstallCount(500);

        $content2->setIsPublish(1);

        $manager->persist($content2);

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