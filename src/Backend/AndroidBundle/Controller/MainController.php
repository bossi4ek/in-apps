<?php

namespace Backend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DomCrawler\Crawler;
use Guzzle\Http\Client;

use Frontend\AndroidBundle\Entity\Content;
use Frontend\AndroidBundle\Entity\Category;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackendAndroidBundle:Main:index.html.twig');
    }

    public function parsAction()
    {
        //pars all categories
        $this->parsCategories();

        // create http client instance
        $client = new Client($this->container->getParameter('pars_host'));
        // create a request
        $request = $client->get('/ru/apps/soft/');
        // send request / get response
        $response = $request->send();
        // this is the response body from the requested page (usually html)
        $result = $response->getBody();

        $crawler = new Crawler();
        $crawler->addContent($result);

        $crawler->filter('#content-list > li')->each(function ($node, $i) {
            $this->processContent($node);
        });

        return new Response(1);
    }

    public function processContent($node)
    {

        $em = $this->getDoctrine()->getManager();

        $categoryRepository = $em->getRepository('FrontendAndroidBundle:Category');
        $developerRepository = $em->getRepository('FrontendAndroidBundle:Developer');

        // create http client instance
        $client = new Client($this->container->getParameter('pars_host'));
        // create a request
        $request = $client->get($node->filter('a')->attr("href"));
        // send request / get response
        $response = $request->send();
        // this is the response body from the requested page (usually html)
        $result = $response->getBody();

        $crawler = new Crawler();
        $crawler->addContent($result);

        $name = $crawler->filter(".si-application h1")->text();
        $description = $crawler->filter(".si-shortstory .paragraph")->text();
        $content = new Content();

        $crawler->filter(".si-category span div")->each(function ($node, $i) use ($content, $categoryRepository) {
            if ($i != 0) {
                $content->addCategory($categoryRepository->findOneBy(array('name' => $node->filter('span')->text())));
            }
        });

        $this->copyImage($content, $this->container->getParameter('pars_host').$node->filter('img')->attr("src"));

        $content->setName($name);
        $content->setDescription($description);
        $content->addDeveloper($developerRepository->findOneBy(array('id' => '1')));
        $content->setSize($crawler->filter(".group-additional span")->eq(3)->text());
        $content->setVersion($crawler->filter(".group-additional span")->eq(2)->text());
        $content->setYear(2013);
        $content->setInstallCount(0);
        $content->setViewCount(0);

        $content->setIsPublish(1);

        $em->persist($content);
        $em->flush();
    }

    public function copyImage($entity, $src)
    {
        $img_data = explode("/", $src);
        $destination = __DIR__.'/../../../../web/uploads/poster';

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
        $client = new Client($this->container->getParameter('pars_host'));
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

        return new Response(1);
    }

    public function processCategory($node)
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName($node->text());
        $category->setIsPublish(1);
        $em->persist($category);

        $em->flush();
    }
//======================================================================================================================


}
