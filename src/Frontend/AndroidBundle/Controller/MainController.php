<?php

namespace Frontend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontendAndroidBundle:Main:index.html.twig');
    }
}
