<?php

namespace Backend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BackendAndroidBundle:Default:index.html.twig', array('name' => $name));
    }
}
