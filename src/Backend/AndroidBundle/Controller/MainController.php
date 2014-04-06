<?php

namespace Backend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackendAndroidBundle:Main:index.html.twig');
    }
}
