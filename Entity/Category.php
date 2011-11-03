<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gpupo\CamelSpiderBundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category
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
     * @ORM\OneToMany(targetEntity="News", mappedBy="category")
     */
    private $newss;

    /**
     * @ORM\OneToMany(targetEntity="Subscription", mappedBy="category")
     */
    private $subscriptions;

    /**
     * Magic method to conver the object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
    public function __construct()
    {
        $this->newss = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add subscriptions
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Subscription $subscriptions
     */
    public function addSubscription(\Gpupo\CamelSpiderBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;
    }

    /**
     * Get subscriptions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }
}