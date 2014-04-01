<?php

namespace Frontend\AndroidBundle\Event;

use Symfony\Component\EventDispatcher\Event;
Use Frontend\AndroidBundle\Entity\Content;
use Doctrine\ORM\EntityManager;

class ContentViewEvent extends Event{

    protected $content;
    protected $em;

    public function __construct(Content $content, EntityManager $em)
    {
        $this->content = $content;
        $this->em = $em;
    }

    public function incContentView()
    {
        $view_count = $this->content->getViewCount();
        $this->content->setViewCount($view_count + 1);

        $this->em->flush();
    }
} 