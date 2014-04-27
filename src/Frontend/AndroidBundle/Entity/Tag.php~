<?php

namespace Frontend\AndroidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column()
     * @Assert\Length(min = "3")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="tags", cascade={"persist"})
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     **/
    private $content;

//    public function __construct() {
//        $this->content = new ArrayCollection();
//    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set content
     *
     * @param \Frontend\AndroidBundle\Entity\Content $content
     * @return Tag
     */
    public function setContent(\Frontend\AndroidBundle\Entity\Content $content = null)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return \Frontend\AndroidBundle\Entity\Content
     */
    public function getContent()
    {
        return $this->content;
    }
}
