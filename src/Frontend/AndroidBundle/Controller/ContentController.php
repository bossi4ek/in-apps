<?php

namespace Frontend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Frontend\AndroidBundle\Event\ContentViewEvent;

class ContentController extends Controller
{

    public function getContentService()
    {
        return $this->get('frontend.android.content');
    }

    public function showAllAction(Request $request)
    {
//        print_r($request->cookies->get('view_type'));
//        $view_type = (!isset($request->cookies->get('view_type')) || $request->cookies->get('view_type') == 'line') ? 'line' : 'block';

        $data = $this->getContentService()->showAllContent();

        $page = $request->get('page');
        $adapter = new DoctrineORMAdapter($data);
        $pagerfanta = new Pagerfanta($adapter);

        if(!$page) {
            $page = 1;
        }
        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'data' => $data,
                'page' => $page,
                'pagerfanta' => $pagerfanta)
        );
    }

    public function showElementAction(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $data = $this->getContentService()->findOneBySlug($slug);

//----------------------------------------------------------------------------------------------------------------------
//inc view_count
        $em = $this->getDoctrine()->getManager();
        $ed = new EventDispatcher();
        $event = new ContentViewEvent($data, $em);
        $ed->addListener("inc_content_view", function(ContentViewEvent $event) {
            $event->incContentView();
        });
        $ed->dispatch("inc_content_view", $event);
//----------------------------------------------------------------------------------------------------------------------

        return $this->render('FrontendAndroidBundle:Content:content.html.twig', array('data' => $data));
    }

    public function showAllByCategoryAction(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $category = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Category')->findOneBy(array('slug' => $slug));
        $data = $this->getContentService()->findAllByCategory($slug);

        $page = $request->get('page');

        $adapter = new DoctrineORMAdapter($data);

        $pagerfanta = new Pagerfanta($adapter);
        if(!$page) {
            $page = 1;
        }

        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'category' => $category,
                'data' => $data,
                'page' => $page,
                'pagerfanta' => $pagerfanta)
        );
    }

    public function showAllByDeveloperAction(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $category = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Developer')->findOneBy(array('slug' => $slug));
        $data = $this->getContentService()->findAllByDeveloper($slug);

        $page = $request->get('page');

        $adapter = new DoctrineORMAdapter($data);

        $pagerfanta = new Pagerfanta($adapter);
        if(!$page) {
            $page = 1;
        }

        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'category' => $category,
                'data' => $data,
                'page' => $page,
                'pagerfanta' => $pagerfanta)
        );
    }

    public function showTopAction()
    {
        $data = $this->getContentService()->findTopContent();

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'data' => $data)
        );
    }

    public function showNewAction()
    {
        $data = $this->getContentService()->findNewContent();

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'data' => $data)
        );
    }

}
