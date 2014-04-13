<?php

namespace Frontend\ParserBundle;

use Doctrine\ORM\EntityManager;

use Symfony\Component\DomCrawler\Crawler;
use Guzzle\Http\Client;

use Frontend\AndroidBundle\Entity\Content;
use Frontend\AndroidBundle\Entity\Category;
use Frontend\AndroidBundle\Entity\Screen;

class ParserApp4smart {

    protected $em;
    protected $host;

    function __construct(EntityManager $entityManager, $host)
    {
        $this->em = $entityManager;
        $this->host = $host;
    }

    public function parsAction($data)
    {
//        if ($data['with_category']) {
//            //pars all categories
//            $this->parsCategories();
//        }

        // create http client instance
        $client = new Client($this->host);
        // create a request
        $request = $client->get($data['url']);

        // send request / get response
        $response = $request->send();
        // this is the response body from the requested page (usually html)
        $result = $response->getBody();

        $crawler = new Crawler();
        $crawler->addContent($result);

        $crawler->filter('#category-box > li')->each(function ($node, $i) {
            $this->processContent($node);
        });

        return true;
    }

    public function processContent($node)
    {
        $categoryRepository = $this->em->getRepository('FrontendAndroidBundle:Category');
        $developerRepository = $this->em->getRepository('FrontendAndroidBundle:Developer');

        // create http client instance
        $client = new Client($this->host);
        // create a request
        $request = $client->get($node->filter('a')->attr("href"));
        // send request / get response
        $response = $request->send();
        // this is the response body from the requested page (usually html)
        $result = $response->getBody();

        $crawler = new Crawler();
        $crawler->addContent($result);

        $name = $crawler->filter(".si-application h1")->text();
        $description = $crawler->filter("#full-story")->text();

//        echo $name."<br/>";
//        echo $description."<br/>";
//        exit;

        $content = new Content();

        $crawler->filter(".si-category span div")->each(function ($node, $i) use ($content, $categoryRepository) {
            if ($i != 0) {
                $category = $node->filter('span')->text();
                if (is_null($categoryRepository->findOneBy(array('name' => $category)))) {
                    $cat = new Category();
                    $cat->setName($category);
                    $cat->setDescription("");
                    $cat->setIsPublish(true);
                    $this->em->persist($cat);
                    $this->em->flush();
                }
                $content->addCategory($categoryRepository->findOneBy(array('name' => $category)));
            }
        });

        $this->copyImage($content, $this->host.$node->filter('img')->attr("src"));

        $content->setName($name);
        $content->setDescription($description);
        $content->addDeveloper($developerRepository->findOneBy(array('id' => '1')));
        $content->setSize($crawler->filter("#size")->count() > 0 ? $crawler->filter("#size")->text() : "");
        $content->setVersion($crawler->filter("#version")->count() > 0 ? $crawler->filter("#version")->text() : "");
        $content->setYear(2013);
        $content->setInstallCount(0);
        $content->setViewCount(0);

        $content->setIsPublish(true);

        $this->em->persist($content);
        $this->em->flush();

        //Screens
        $crawler->filter(".story-gallery .fancybox-thumb img")->each(function ($node, $i) use ($content, $categoryRepository) {
            $this->copyScreen($content, $this->host.$node->attr("src"));
        });
    }

    public function copyImage($entity, $src)
    {
        $img_data = explode("/", $src);
        $destination = __DIR__.'/../../../web/uploads/poster';

        if (copy($src, $destination."/".$img_data[count($img_data) - 1])) {
            $entity->setPosterImg($img_data[count($img_data) - 1]);
        }
        else {
            $entity->setPosterImg(null);
        }

        return 1;
    }

    public function copyScreen($entity, $src)
    {
        $img_data = explode("/", $src);
        $destination = __DIR__.'/../../../web/uploads/poster';

        if (copy($src, $destination."/".$img_data[count($img_data) - 1])) {
            $screen = new Screen();
            $screen->setImg($img_data[count($img_data) - 1]);
            $screen->setContent($entity);
            $this->em->persist($screen);
            $this->em->flush();
        }

        return 1;
    }

//======================================================================================================================
//Pars categories
    public function parsCategories()
    {
        // create http client instance
        $client = new Client($this->host);
        // create a request
        $request = $client->get('/ru/apps/soft/');
        // send request / get response
        $response = $request->send();
        // this is the response body from the requested page (usually html)
        $result = $response->getBody();

        $crawler = new Crawler();
        $crawler->addContent($result);

        $crawler->filter('.categories > li')->each(function ($node, $i) {
            if ($node->filter('a')->attr("data-value") != 0) {
                $this->processCategory($node);
            }
        });

        return true;
    }

    public function processCategory($node)
    {
        $category = new Category();
        $category->setName($node->text());
        $category->setIsPublish(true);
        $this->em->persist($category);

        $this->em->flush();
    }
//======================================================================================================================

}