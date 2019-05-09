<?php

# https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/association-mapping.html
# Maneira de fazer associação. usar o inverseby

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Component
 *
 * @ORM\Table(name="component")
 * @ORM\Entity(repositoryClass="BaseBundle\Repository\ComponentRepository")
 */
class Component
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }
    
    /**
     * @param User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }


    /**
     * @var Surrounding
     *
     * @ORM\ManyToOne(targetEntity="BaseBundle\Entity\Surrounding")
     * @ORM\JoinColumn(nullable=false)
     */
    private $surrounding;


    /**
     * @return Surrounding
     */
    public function getSurrounding() {
        return $this->surrounding;
    }

    /**
     * @param Surrounding $surrounding
     */
    public function setSurrounding($surrounding) {
        $this->surrounding = $surrounding;
    }

    /**
     * Bidirectional - Many comments are favorited by many users (INVERSE SIDE)
     *
     * @ORM\ManyToMany(targetEntity="Scenery", mappedBy="components")
     */
    private $sceneries;


    public function __construct() {
        $this->sceneryComponents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Component
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Component
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Component
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();

    }
}

