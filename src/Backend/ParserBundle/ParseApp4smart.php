<?php

namespace Backend\ParserBundle;

use Doctrine\ORM\EntityManager;

use Symfony\Component\DomCrawler\Crawler;
use Guzzle\Http\Client;

use Frontend\AndroidBundle\Entity\Content;
use Frontend\AndroidBundle\Entity\Category;

class ParseApp4smart {

    protected $em;
    protected $host;

    function __construct(EntityManager $entityManager, $host)
    {
        $this->em = $entityManager;
        $this->host = $host;
    }

    public function parsAction($data)
    {
        if ($data['with_category']) {
            //pars all categories
            $this->parsCategories();
        }

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

        $content = new Content();

        $crawler->filter(".si-category span div")->each(function ($node, $i) use ($content, $categoryRepository) {
            if ($i != 0) {
                $content->addCategory($categoryRepository->findOneBy(array('name' => $node->filter('span')->text())));
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

        $content->setIsPublish(1);

        $this->em->persist($content);
        $this->em->flush();
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
        $category->setIsPublish(1);
        $this->em->persist($category);

        $this->em->flush();
    }
//======================================================================================================================

}