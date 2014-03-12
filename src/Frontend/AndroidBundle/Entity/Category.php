<?php

namespace Frontend\AndroidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column()
     * @Assert\Length(min = "2")
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */

    private $slug;

    /**
     * @ORM\Column(type="smallint")
     */
    private $is_publish;

    /**
     * ORM\@ManyToMany(targetEntity="Content", mappedBy="categories")
     **/
    private $contents;

    public function __construct() {
        $this->contents = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set is_publish
     *
     * @param integer $isPublish
     * @return Category
     */
    public function setIsPublish($isPublish)
    {
        $this->is_publish = $isPublish;

        return $this;
    }

    /**
     * Get is_publish
     *
     * @return integer 
     */
    public function getIsPublish()
    {
        return $this->is_publish == 1 ? true : false;
    }
}
