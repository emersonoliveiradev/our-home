<?php

namespace BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Surrounding
 *
 * @ORM\Table(name="surrounding")
 * @ORM\Entity(repositoryClass="BaseBundle\Repository\SurroundingRepository")
 */
class Surrounding
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Surrounding
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();

    }


    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Surrounding
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }




    #Não tenho certeza e o que está abaixo é realmente importante

    /**
     * @ORM\OneToMany(targetEntity="BaseBundle\Entity\Component", mappedBy="surrounding")
     */
    private $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    #Rever
    /**
     * @return Collection|Component[]
     */
    public function getComponents(): Collection {
        return $this->components;
    }






}
