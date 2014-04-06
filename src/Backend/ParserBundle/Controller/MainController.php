<?php

namespace Backend\ParserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Backend\ParserBundle\Form\ParseApp4smartType;

class MainController extends Controller
{
    public function app4smartAction(Request $request)
    {
        $form = $this->createForm(new ParseApp4smartType());

        $form->handleRequest($request);

        $result_txt = "";
        if ($form->isValid()) {
            $result = $this->get('backend.parser.parse.App4smart')->parsAction($form->getData());
            $result_txt = $result ? "Pars ended successfully!" : "ERROR";

        }

        return $this->render('BackendParserBundle:Main:index.html.twig', array(
                'result' => $result_txt,
                'form' => $form->createView())
        );
    }
}
