<?php

namespace Frontend\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FrontendUserBundle:Default:index.html.twig', array('name' => $name));
    }

    public function showMyContentAction(Request $request)
    {
        $user = $this->getUser()->getId();

        $content = $this->getDoctrine()
            ->getRepository('FrontendUserBundle:User')
            ->findOneById($user);

        $data = $content->getContents();

        return $this->render('FrontendUserBundle:Mycontent:mycontent_all.html.twig',
            array(
                'data' => $data
            ));
    }

    public function addMyContentAction(Request $request)
    {
        //find content
        $id_content = $request->request->get('id');
        $content = $this->getDoctrine()
            ->getRepository('FrontendAndroidBundle:Content')
            ->findOneById($id_content);

        //find user
        $id_user = $this->getUser()->getId();
        $user_data = $this->getDoctrine()
            ->getRepository('FrontendUserBundle:User')
            ->findOneById($id_user);

        //add new content for user
        $user_data->addContent($content);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response(1);
    }

    public function delMyContentAction(Request $request)
    {
        //find content
        $id_content = $request->request->get('id');
        $content = $this->getDoctrine()
            ->getRepository('FrontendAndroidBundle:Content')
            ->findOneById($id_content);

        //find user
        $id_user = $this->getUser()->getId();
        $user_data = $this->getDoctrine()
            ->getRepository('FrontendUserBundle:User')
            ->findOneById($id_user);

        //add new content for user
        $user_data->removeContent($content);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response(1);
    }
}
