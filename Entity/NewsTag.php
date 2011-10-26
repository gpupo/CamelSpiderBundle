<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gpupo\CamelSpiderBundle\Entity\NewsTag
 *
 * @ORM\Table(name="news_tag")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\NewsTagRepository")
 * @ORM\HasLifecycleCallbacks
 */
class NewsTag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="News", mappedBy="tags")
     */
    private $newss;

    public function __construct() {
        $this->newss = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Magic method to conver the object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Add newss
     *
     * @param Gpupo\CamelSpiderBundle\Entity\News $newss
     */
    public function addNews(\Gpupo\CamelSpiderBundle\Entity\News $newss)
    {
        $this->newss[] = $newss;
    }

    /**
     * Get newss
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getNewss()
    {
        return $this->newss;
    }
}