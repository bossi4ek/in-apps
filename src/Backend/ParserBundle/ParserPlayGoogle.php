<?php

namespace Backend\ParserBundle;

use Doctrine\ORM\EntityManager;

use Symfony\Component\DomCrawler\Crawler;
use Guzzle\Http\Client;

use Frontend\AndroidBundle\Entity\Content;
use Frontend\AndroidBundle\Entity\Category;

class ParserPlayGoogle {

    protected $em;
    protected $host;

    function __construct(EntityManager $entityManager, $host)
    {
        $this->em = $entityManager;
        $this->host = $host;
    }

    public function parsAction($data)
    {

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

        $crawler->filter('.card-content-link')->each(function ($node, $i) {
            $this->processContent($node);
            exit;
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
        $request = $client->get($node->attr("href"));
        // send request / get response
        $response = $request->send();
        // this is the response body from the requested page (usually html)
        $result = $response->getBody();

        $crawler = new Crawler();
        $crawler->addContent($result);

        $name = $crawler->filter(".document-title div")->text();
        $description = $crawler->filter(".id-app-orig-desc")->text();
        $category = $crawler->filter('span[itemprop="genre"]')->text();
//        $view_count = preg_replace("/\(|\)/", "", $crawler->filter(".stars-count")->text());


//        echo mb_detect_encoding($crawler->filter('span[itemprop="genre"]')->text());
//
//        echo '<meta charset="utf-8">';
//        echo $name."<br/>";
//        echo iconv("windows-1251", "UTF-8", $category)."<br/>";
//        echo $crawler->filter('img.cover-image')->attr("src")."<br/>";
//        var_dump($categoryRepository->findOneBy(array('name' => $category)));
//        exit;

        $content = new Content();

        if (is_null($categoryRepository->findOneBy(array('name' => $category)))) {
            $cat = new Category();
            $cat->setName($category);
            $cat->setIsPublish(1);
            $this->em->persist($cat);
            $this->em->flush();
        }
        $content->addCategory($categoryRepository->findOneBy(array('name' => $category)));

//        $crawler->filter(".si-category span div")->each(function ($node, $i) use ($content, $categoryRepository) {
//            if ($i != 0) {
//                $content->addCategory($categoryRepository->findOneBy(array('name' => $node->filter('span')->text())));
//            }
//        });

        $this->copyImage($content, $crawler->filter('img.cover-image')->attr("src"));

        $content->setName($name);
        $content->setDescription($description);
        $content->addDeveloper($developerRepository->findOneBy(array('id' => '1')));
        $content->setSize($crawler->filter('div[itemprop="fileSize"]')->count() > 0 ? $crawler->filter('div[itemprop="fileSize"]')->text() : "");
        $content->setVersion($crawler->filter('div[itemprop="softwareVersion"]')->count() > 0 ? $crawler->filter('div[itemprop="softwareVersion"]')->text() : "");
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

}