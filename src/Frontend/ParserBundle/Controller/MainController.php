<?php

namespace Frontend\ParserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Frontend\ParserBundle\Form\ParserApp4smartType;
use Frontend\ParserBundle\Form\ParserPlayGoogleType;

class MainController extends Controller
{
    public function app4smartAction(Request $request)
    {
        $form_app4smart = $this->createForm(new ParserApp4smartType());
        $form_app4smart->handleRequest($request);
        $result_app4smart = "";
        if ($form_app4smart->isValid()) {
            $result = $this->get('frontend.parser.parser.app4smart')->parsAction($form_app4smart->getData());
            $result_app4smart = $result ? "Pars ended successfully!" : "ERROR";

        }

        $form_play_google = $this->createForm(new ParserPlayGoogleType());
        $form_play_google->handleRequest($request);
        $result_play_google = "";
        if ($form_play_google->isValid()) {
            $result2 = $this->get('frontend.parser.parser.playGoogle')->parsAction($form_play_google->getData());
            echo $result2;
            $result_play_google = $result2 ? "Pars ended successfully!" : "ERROR";

        }

        return $this->render('FrontendParserBundle:Main:index.html.twig', array(
                'result_app4smart' => $result_app4smart,
                'result_play_google' => $result_play_google,
                'form_app4smart' => $form_app4smart->createView(),
                'form_play_google' => $form_play_google->createView())
        );
    }
}
