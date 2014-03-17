<?php

namespace Backend\AndroidBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Frontend\AndroidBundle\Entity\Content;
use Frontend\AndroidBundle\Entity\Category;
use Frontend\AndroidBundle\Entity\Developer;

use Backend\AndroidBundle\Form\ContentType;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class ContentController extends Controller
{

    public function getContentService()
    {
        return $this->get('content');
    }

    public function showAllAction(Request $request)
    {
        $data = $this->getContentService()->showAllContent();

        $page = $request->get('page');
        $adapter = new DoctrineORMAdapter($data);
        $pagerfanta = new Pagerfanta($adapter);

        if(!$page) {
            $page = 1;
        }
        $pagerfanta->setMaxPerPage($this->container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        return $this->render('BackendAndroidBundle:Content:content_all.html.twig',
                            array(
                                'data' => $data,
                                'page' => $page,
                                'pagerfanta' => $pagerfanta
                            ));
    }

    public function showElementAction()
    {
    }

    public function addElementAction(Request $request)
    {
        $content_obj = new Content();
        $form = $this->createForm(new ContentType(), $content_obj, array("validation_groups" => array("AddContent")));

        $form->handleRequest($request);

        if ($form->isValid()) {

            $content_obj->setIsPublish($content_obj->getIsPublish() == false ? 0 : $content_obj->getIsPublish());

            $em = $this->getDoctrine()->getManager();
            $em->persist($content_obj);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_content'));
        }

        return $this->render('BackendAndroidBundle:Content:content.html.twig', array(
                'action' => $this->generateUrl('backend_content_add'),
                'content' => $content_obj,
                'form' => $form->createView())
        );
    }

    public function editElementAction(Request $request)
    {
    }

    public function delElementAction(Request $request) {
        //find id_element
        $id_element = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('FrontendAndroidBundle:Content')->findOneById($id_element);
        $em->remove($content);
        //remove the relationship
        foreach ($content->getTags() as $tag) {
            //delete the Tag entirely
            $em->remove($tag);
        }
        $em->flush();

        return new Response(1);
    }
}
