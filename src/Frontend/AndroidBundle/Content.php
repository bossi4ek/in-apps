<?php

namespace Frontend\AndroidBundle;

use Frontend\AndroidBundle\Repository\ContentRepository;

class Content {

    private $repo;

    function __construct(ContentRepository $repo)
    {
        $this->repo = $repo;
    }

//Get all content
    public function showAllContent(){
        return $this->repo->findAllContent();
    }

//Get all Content is_publish = 1
    public function showAllContentIsPublish(){
        return $this->repo->findAllContentByIsPublish();
    }

//Get one Element by slug
    public function findOneBySlug($slug){
        return $this->repo->findOneBySlug($slug);
    }

//Get Content by category
    public function findAllByCategory($slug){
        return $this->repo->findAllByCategory($slug);
    }

//Get Content by developer
    public function findAllByDeveloper($slug){
        return $this->repo->findAllByDeveloper($slug);
    }
}