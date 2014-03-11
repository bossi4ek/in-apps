<?php

namespace Frontend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FrontendAndroidBundle:Main:index.html.twig', array('name' => $name));
    }
}
