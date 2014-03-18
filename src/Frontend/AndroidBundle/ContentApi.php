<?php

namespace Frontend\AndroidBundle;

use Frontend\AndroidBundle\Repository\ContentRepository;

class ContentApi {

    private $repo;

    function __construct(ContentRepository $repo)
    {
        $this->repo = $repo;
    }

//Get all content
    public function showApiAllContent(){
        return $this->repo->findApiAllContent();
    }

//Get content by ID
    public function showApiContent($id){
        return $this->repo->findApiContentById($id);
    }
}