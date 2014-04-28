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
use Frontend\AndroidBundle\Entity\StaticPage;

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
    public function loadStaticPage(ObjectManager $manager)
    {
        $name = 'Добро пожаловать';
        $page = new StaticPage();
        $page->setName($name);
        $page->setDescription("Операционная система андроид предоставляет своим пользователям множество возможностей.
                        На данный момент существует более сотни тысяч приложений для смартфонов и планшетов – различных программ
                        для увеличения функциональности устройств, общения в интернете, игр и многих других. Возможности любого
                        коммуникатора всегда можно увеличить за счет использования сторонних программ, будь это
                        альтернативный браузер или хаб. Разобраться в этом огромном ассортименте уже не так просто.
                        Этот сайт предоставляет Вам такую возможность!");
        $page->setIsPublish(true);
        $page->setMetaTitle("Android OS. Игры, программы, приложения для Андроид смартфонов и планшетов.");
        $page->setMetaDescription("Android, приложения для андроид, бесплатные приложения для андроид");
        $page->setMetaKeywords("");
        $manager->persist($page);
    }

//======================================================================================================================
    public function loadDeveloper(ObjectManager $manager)
    {
        $name = 'Тест1';
        $dev1 = new Developer();
        $dev1->setName($name);
        $dev1->setIsPublish(true);
        $dev1->setMetaTitle($name);
        $dev1->setMetaDescription("Разработчик ".$name);
        $dev1->setMetaKeywords("");
        $manager->persist($dev1);

        $name = 'Тест2';
        $dev2 = new Developer();
        $dev2->setName($name);
        $dev2->setIsPublish(true);
        $dev2->setMetaTitle($name);
        $dev2->setMetaDescription("Разработчик ".$name);
        $dev2->setMetaKeywords("");
        $manager->persist($dev2);

        $manager->flush();
    }

//======================================================================================================================
    public function loadCategory(ObjectManager $manager)
    {
        $name = 'Игры';
        $category1 = new Category();
        $category1->setName($name);
        $category1->setDescription("Игры для Android. Здесь много игр");
        $category1->setMetaTitle("Категория ".$name);
        $category1->setMetaDescription("Игры для Android. Здесь много игр");
        $category1->setMetaKeywords("Игры для Android, Android, Скачать игры для андроид");
        $category1->setIsPublish(true);
        $manager->persist($category1);

        $name = 'Бизнес';
        $category2 = new Category();
        $category2->setName($name);
        $category2->setDescription("Бизнес приложения для ОС Android");
        $category2->setMetaTitle("Категория ".$name);
        $category2->setMetaDescription("Бизнес приложения для ОС Android");
        $category2->setMetaKeywords("Бизнес приложения для Android, Android, Скачать Бизнес приложения для андроид");
        $category2->setIsPublish(true);
        $manager->persist($category2);

        $name = 'Виджеты';
        $category3 = new Category();
        $category3->setName($name);
        $category3->setDescription("Виджеты для Android");
        $category3->setMetaTitle("Категория ".$name);
        $category3->setMetaDescription("Игры для Android. Здесь много игр");
        $category3->setMetaKeywords("Виджеты для Android. Android виджеты, анроид виджеты");
        $category3->setIsPublish(true);
        $manager->persist($category3);

        $name = 'Медицина';
        $category4 = new Category();
        $category4->setName($name);
        $category4->setDescription("Приложения на тему медыцины для Android");
        $category4->setMetaTitle("Категория ".$name);
        $category4->setMetaDescription("Приложения на тему медыцины для Android");
        $category4->setMetaKeywords("Медыцинские приложения для Android");
        $category4->setIsPublish(true);
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
        $content1->setLikeCount(12);
        $content1->setMetaTitle($name);
        $content1->setMetaDescription($description);
        $content1->setMetaKeywords("BADLAND для Android, BADLAND, игра BADLAND");

        $content1->setIsPublish(true);

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
        $content2->setLikeCount(1);
        $content2->setMetaTitle($name);
        $content2->setMetaDescription($description);
        $content2->setMetaKeywords("Can Knockdown 3 для Android, Can Knockdown 3");

        $content2->setIsPublish(true);

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
        $content3->setLikeCount(0);
        $content3->setMetaTitle($name);
        $content3->setMetaDescription($description);
        $content3->setMetaKeywords("Gravity Maze, Gravity Maze для Android");

        $content3->setIsPublish(true);

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
        $content4->setLikeCount(0);
        $content4->setMetaTitle($name);
        $content4->setMetaDescription($description);
        $content4->setMetaKeywords("Hungry Shark Evolution, Hungry Shark Evolution для Android");

        $content4->setIsPublish(true);

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

        $this->loadStaticPage($manager);
        $this->loadDeveloper($manager);
        $this->loadCategory($manager);
        $this->loadContent($manager);
        $this->loadUser();
    }
}