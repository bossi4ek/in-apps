<?php

namespace Frontend\AndroidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo; // Подключение Gedmo

/**
 * @ORM\Entity
 * @ORM\Table(name="screen")
 */
class Screen {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column()
     * @Assert\Length(min = "2")
     */
    protected $img;

    /**
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="screens")
     * @ORM\JoinColumn(name="id_content", referencedColumnName="id")
     */
    private $content;

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
     * Set img
     *
     * @param string $img
     * @return Screen
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set content
     *
     * @param \Frontend\AndroidBundle\Entity\Content $content
     * @return Screen
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
