<?php

namespace Backend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Frontend\AndroidBundle\Entity\Developer;
use Backend\AndroidBundle\Form\DeveloperType;
use Symfony\Component\HttpFoundation\Response;

class DeveloperController extends Controller
{
    public function showAllAction()
    {
        $data = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Developer')->findAll();

        return $this->render('BackendAndroidBundle:Developer:developer_all.html.twig', array('data' => $data));
    }

    public function showElementAction()
    {
    }

    public function showCategoryInMenuAction(Request $request)
    {
        $developer = $this->getDoctrine()->getRepository('BackendAndroidBundle:Developer')->findAll();

        return $this->render('BackendAndroidBundle:Developer:developer_in_menu.html.twig', array('developer' => $developer));
    }

    public function addElementAction(Request $request)
    {
        $obj = new Developer();
        $form = $this->createForm(new DeveloperType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $obj->setIsPublish($obj->getIsPublish() == false ? 0 : $obj->getIsPublish());

            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_developer'));
        }

        return $this->render('BackendAndroidBundle:Developer:developer.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function editElementAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('FrontendAndroidBundle:Developer')->findOneById($id);

        $form = $this->createForm(new DeveloperType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('backend_developer'));
        }

        return $this->render('BackendAndroidBundle:Developer:developer.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function delElementAction(Request $request) {
        //find id_element
        $id_element = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $element = $em->getRepository('FrontendAndroidBundle:developer')->findOneById($id_element);

        $em->remove($element);
        $em->flush();

        return new Response(1);
    }
}
