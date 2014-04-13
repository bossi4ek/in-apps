<?php

namespace Frontend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Entity\Category;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontendAndroidBundle:Main:index.html.twig');
    }

    public function showCategoryInMenuAction()
    {
        $data = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Category')->findAll();

        return $this->render('FrontendAndroidBundle:Category:category_in_menu.html.twig', array('data' => $data));
    }

    public function showRecommendedAction()
    {
        $data = $this->get('frontend.android.content')->findTopContent();

        return $this->render('FrontendAndroidBundle:Main:recommended.html.twig', array(
                'data' => $data)
        );
    }
}
