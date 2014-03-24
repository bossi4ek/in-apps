<?php

namespace Frontend\AndroidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo; // Подключение Gedmo

/**
 * @ORM\Entity(repositoryClass="Frontend\AndroidBundle\Repository\ContentRepository")
 * @ORM\Table(name="content")
 * @ORM\HasLifecycleCallbacks
 */
class Content {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column()
     * @Assert\Length(min = "5", groups={"AddContent"})
     * @Assert\Length(min = "2", groups={"EditContent"})
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, separator="_")
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */

    private $slug;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", options={"default" = 0})
     */
    private $is_publish;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank(groups={"AddContent", "EditContent"})
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="Год состоит только с цыфр",
     *     groups={"AddContent", "EditContent"}
     * )
     */
    private $year;

    /**
     * @ORM\Column()
     */
    private $size;

    /**
     * @ORM\Column()
     */
    private $version;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank(groups={"AddContent", "EditContent"})
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="Количество установок состоит только с цыфр",
     *     groups={"AddContent", "EditContent"}
     * )
     */
    private $install_count;

    /**
     * @var string $image
     *
     * @ORM\Column(name="poster_img", type="string", length=255, nullable=true)
     */
    private $poster_img;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    private $temp;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="contents")
     * @ORM\JoinTable(name="content_category")
     **/
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Developer", inversedBy="contents")
     * @ORM\JoinTable(name="content_developer")
     **/
    private $developers;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="content", cascade={"persist"})
     **/
    private $tags;

    /**
     * ORM\@ManyToMany(targetEntity="Frontend\UserBundle\Entity\User", mappedBy="contents")
     **/
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="content")
     */
    protected $comments;


    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->developers = new ArrayCollection();
        $this->tags = new ArrayCollection();

        $this->users = new ArrayCollection();

        $this->comments = new ArrayCollection();
    }

//======================================================================================================================
//For uploads poster
//======================================================================================================================

    public function getAbsolutePath()
    {
        return null === $this->poster_img
            ? null
            : $this->getUploadRootDir().'/'.$this->poster_img;
    }

    public function getWebPath()
    {
        return null === $this->poster_img
            ? null
            : $this->getUploadDir().'/'.$this->poster_img;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/uploads/poster';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->poster_img)) {
            // store the old name to delete after the update
            $this->temp = $this->poster_img;
            $this->poster_img = null;
        } else {
            $this->poster_img = 'initial';
        }
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->poster_img = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->poster_img);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
//======================================================================================================================

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
     * @return Content
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
     * @return Content
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
     * Set created
     *
     * @param \DateTime $created
     * @return Content
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Content
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Content
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set is_publish
     *
     * @param integer $isPublish
     * @return Content
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

    /**
     * Set year
     *
     * @param integer $year
     * @return Content
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Content
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Content
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set install_count
     *
     * @param integer $installCount
     * @return Content
     */
    public function setInstallCount($installCount)
    {
        $this->install_count = $installCount;

        return $this;
    }

    /**
     * Get install_count
     *
     * @return integer 
     */
    public function getInstallCount()
    {
        return $this->install_count;
    }

    /**
     * Set poster_img
     *
     * @param string $posterImg
     * @return Content
     */
    public function setPosterImg($posterImg)
    {
        $this->poster_img = $posterImg;

        return $this;
    }

    /**
     * Get poster_img
     *
     * @return string 
     */
    public function getPosterImg()
    {
        if (null === $this->poster_img) {
            return;
        }

        return $this->getWebPath();
    }

    /**
     * Add categories
     *
     * @param \Frontend\AndroidBundle\Entity\Category $categories
     * @return Content
     */
    public function addCategory(\Frontend\AndroidBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Frontend\AndroidBundle\Entity\Category $categories
     */
    public function removeCategory(\Frontend\AndroidBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add developers
     *
     * @param \Frontend\AndroidBundle\Entity\Developer $developers
     * @return Content
     */
    public function addDeveloper(\Frontend\AndroidBundle\Entity\Developer $developers)
    {
        $this->developers[] = $developers;

        return $this;
    }

    /**
     * Remove developers
     *
     * @param \Frontend\AndroidBundle\Entity\Developer $developers
     */
    public function removeDeveloper(\Frontend\AndroidBundle\Entity\Developer $developers)
    {
        $this->developers->removeElement($developers);
    }

    /**
     * Get developers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDevelopers()
    {
        return $this->developers;
    }

    /**
     * Add tags
     *
     * @param \Frontend\AndroidBundle\Entity\Tag $tags
     * @return Content
     */
    public function addTag(\Frontend\AndroidBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Frontend\AndroidBundle\Entity\Tag $tags
     */
    public function removeTag(\Frontend\AndroidBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add comments
     *
     * @param \Frontend\AndroidBundle\Entity\Comment $comments
     * @return Content
     */
    public function addComment(\Frontend\AndroidBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Frontend\AndroidBundle\Entity\Comment $comments
     */
    public function removeComment(\Frontend\AndroidBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
