<?php

namespace Backend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Frontend\AndroidBundle\Entity\Category;
use Backend\AndroidBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function showAllAction()
    {
        $data = $this->getDoctrine()->getRepository('FrontendAndroidBundle:Category')->findAll();

        return $this->render('BackendAndroidBundle:Category:category_all.html.twig', array('data' => $data));
    }

    public function showElementAction()
    {
    }

    public function addElementAction(Request $request)
    {
        $obj = new Category();
        $form = $this->createForm(new CategoryType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $obj->setIsPublish($obj->getIsPublish() == false ? 0 : $obj->getIsPublish());

            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_category'));
        }

        return $this->render('BackendAndroidBundle:Category:category.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function editElementAction(Request $request)
    {
        $id = $request->attributes->get('id');
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('FrontendAndroidBundle:Category')->findOneById($id);

        $form = $this->createForm(new CategoryType(), $obj);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('backend_category'));
        }

        return $this->render('BackendAndroidBundle:Category:category.html.twig', array(
                'form' => $form->createView())
        );
    }

    public function delElementAction(Request $request) {
        //find id_element
        $id_element = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $element = $em->getRepository('FrontendAndroidBundle:Category')->findOneById($id_element);

        $em->remove($element);
        $em->flush();

        return new Response(1);
    }
}
