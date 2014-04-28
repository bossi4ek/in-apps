<?php

namespace Frontend\AndroidBundle;

use Frontend\AndroidBundle\Repository\ContentRepository;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class Content {

    private $repo;
    private $security_context;

    function __construct(ContentRepository $repo, $security_context, $service_container)
    {
        $this->repo = $repo;
        $this->security_context = $security_context;
        $this->service_container = $service_container;
    }

//======================================================================================================================
//Get all content
    public function showAllContent($page)
    {
        $data = $this->repo->findAllContent();

        return $this->getPagerfantaData($page, $data);
    }

//======================================================================================================================
//Get all Content is_publish = 1
    public function showAllContentIsPublish()
    {
        return $this->repo->findAllContentByIsPublish();
    }

//======================================================================================================================
//Get one Element by slug
    public function findOneBySlug($slug)
    {
        $data = $this->repo->findOneBySlug($slug);
        $is_my = $this->checkExistContentInUser($data->getId());
        $data->setIsMy($is_my);

        return $data;
    }

//======================================================================================================================
//Get Elements by name
    public function findContentByName($name)
    {
        $data = $this->repo->findContentByName($name);

        if (count($data) > 0) {
            foreach ($data as $value) {
                $is_my = $this->checkExistContentInUser($value->getId());
                $value->setIsMy($is_my);
            }
        }

        return $data;
    }

//======================================================================================================================
//Get top Content (by view_count)
    public function findTopContent()
    {
        $data = $this->repo->findTopContent();

        foreach ($data as $value) {
            $is_my = $this->checkExistContentInUser($value->getId());
            $value->setIsMy($is_my);
        }

        return $data;
    }

//======================================================================================================================
//Get top Content by category (by view_count)
    public function findTopContentByCategory($slug)
    {
        return $this->repo->findTopContentByCategory($slug);
    }

//======================================================================================================================
//Get new Content (by created)
    public function findNewContent()
    {
        $data = $this->repo->findNewContent();

        foreach ($data as $value) {
            $is_my = $this->checkExistContentInUser($value->getId());
            $value->setIsMy($is_my);
        }

        return $data;
    }

//======================================================================================================================
//Get Content by category
    public function findAllByCategory($slug, $page)
    {
        $data = $this->repo->findAllByCategory($slug);

        return $this->getPagerfantaData($page, $data);
    }

//======================================================================================================================
//Get Content by developer
    public function findAllByDeveloper($slug, $page)
    {
        $data = $this->repo->findAllByDeveloper($slug);

        return $this->getPagerfantaData($page, $data);
    }

//======================================================================================================================
//Check Exist Content In User
    public function checkExistContentInUser($id_content)
    {
        $result = 0;
        if (true === $this->security_context->isGranted('ROLE_USER')) {
            $id_user = $this->security_context->getToken()->getUser()->getId();
            $result = $this->repo->checkExistContentInUser($id_content, $id_user);
        }

        return $result;
    }

//======================================================================================================================
//
    public function getPagerfantaData($page, $data)
    {
        $adapter = new DoctrineORMAdapter($data);
        $pagerfanta = new Pagerfanta($adapter);

        if(!$page) {
            $page = 1;
        }
        $pagerfanta->setMaxPerPage($this->service_container->getParameter('element_per_page'));
        $pagerfanta->setCurrentPage($page);
        $data = $pagerfanta->getCurrentPageResults();

        if (count($data) > 0) {
            foreach ($data as $value) {
                $is_my = $this->checkExistContentInUser($value->getId());
                $value->setIsMy($is_my);
            }
        }

        $result = array(
            'data' => $data,
            'page' => $page,
            'pagerfanta' => $pagerfanta
        );

        return $result;
    }

}