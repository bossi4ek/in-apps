<?php

namespace Frontend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Frontend\AndroidBundle\Event\ContentViewEvent;
use Frontend\CommentBundle\Form\CommentType;

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

        $data = $this->getContentService()->showAllContent($request->get('page'));

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'data' => $data['data'],
                'page' => $data['page'],
                'pagerfanta' => $data['pagerfanta'])
        );
    }

    public function showElementAction(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $data = $this->getContentService()->findOneBySlug($slug);

        $comment_form = $this->createForm(new CommentType());

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

        return $this->render('FrontendAndroidBundle:Content:content.html.twig', array(
                'data' => $data,
                'comment_form' => $comment_form->createView())
        );
    }

    public function showAllByCategoryAction(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $page = $request->get('page');

        $category = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Category')->findOneBy(array('slug' => $slug));
        $data = $this->getContentService()->findAllByCategory($slug, $page);

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'category' => $category,
                'data' => $data['data'],
                'page' => $data['page'],
                'pagerfanta' => $data['pagerfanta'])
        );
    }

    public function showAllByDeveloperAction(Request $request)
    {
        $slug = $request->attributes->get('slug');
        $page = $request->get('page');

        $developer = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Developer')->findOneBy(array('slug' => $slug));
        $data = $this->getContentService()->findAllByDeveloper($slug, $page);

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'developer' => $developer,
                'data' => $data['data'],
                'page' => $data['page'],
                'pagerfanta' => $data['pagerfanta'])
        );
    }

    public function showTopAction()
    {
        $data = $this->getContentService()->findTopContent();

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'data' => $data)
        );
    }

    public function showTopByCategoryAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('FrontendAndroidBundle:Category')->findOneBy(array('slug' => $slug));

        $data = $this->getContentService()->findTopContentByCategory($slug);

        return $this->render('FrontendAndroidBundle:Content:content_top_by_category.html.twig', array(
                'category' => $category,
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

//======================================================================================================================
    public function showSearchUrlAction(Request $request)
    {
        $name = $request->request->get('name');
//        $name = "xxx";

        return $this->redirect($this->generateUrl('frontend_search_by_name', array('name' => $name)));
    }

//======================================================================================================================
    public function searchContentByNameAction(Request $request)
    {
        $name = $request->attributes->get('name');
        $data = $this->getContentService()->findContentByName($name);

        return $this->render('FrontendAndroidBundle:Content:content_all.html.twig', array(
                'search_name' => $name,
                'data' => $data)
        );
    }

}
