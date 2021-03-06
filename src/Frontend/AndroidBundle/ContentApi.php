<?php

namespace Frontend\AndroidBundle;

use Frontend\AndroidBundle\Repository\ContentRepository;

class ContentApi {

    private $repo;

    function __construct(ContentRepository $repo)
    {
        $repo->setIsApi(true);
        $this->repo = $repo;
    }

//Get all content
    public function showApiAllContent(){
        return $this->repo->findAllContent();
    }

//Get content by ID
    public function showApiOneContentById($id){
        return $this->repo->findOneContentById($id);
    }

//Get content by category
    public function showApiContentByCategory($slug){
        return $this->repo->findAllByCategory($slug);
    }

//Get content by developer
    public function showApiContentByDeveloper($slug){
        return $this->repo->findAllByDeveloper($slug);
    }

//Get content top
    public function showApiTopContent(){
        return $this->repo->findTopContent();
    }

//Get content new
    public function showApiNewContent(){
        return $this->repo->findNewContent();
    }

}