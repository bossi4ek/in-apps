<?php

namespace Frontend\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Frontend\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    protected $firstname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=100)
     */
    protected $lastname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="facebookId", type="string", length=50)
     */
    protected $facebookId = '';

}