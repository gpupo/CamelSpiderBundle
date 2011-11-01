<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gpupo\CamelSpiderBundle\Entity\News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\NewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class News
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $uri
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var text $annotation
     *
     * @ORM\Column(name="annotation", type="text", nullable=true)
     */
    private $annotation;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string $moderation
     *
     * @ORM\Column(name="moderation", type="string", length=255)
     */
    private $moderation;

    /**
     * @ORM\ManyToOne(targetEntity="Subscription")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     */
    private $subscription;

    /**
     * @ORM\OneToOne(targetEntity="RawNews")
     * @ORM\JoinColumn(name="rawnews_id", referencedColumnName="id")
     */
    private $rawnews;

    /**
     * @var datetime $createdBy
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var integer $updated_by
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    private $updatedBy;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="newss")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="NewsTag", inversedBy="newss")
     * @ORM\JoinTable(name="ref_news_tag")
     */
    private $tags;

    /**
     * The class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Pre persist hook
     *
     * @ORM\PrePersist
     *
     * @return void
     */
    public function prePersist()
    {
        if (!$this->getId()) {
            $this->createdAt = new \DateTime(date('Y-m-d H:m:s'));
        }
        $this->updatedAt = new \DateTime(date('Y-m-d H:m:s'));
    }

    /**
     * Pre update hook
     *
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime(date('Y-m-d H:m:s'));
    }

    /**
     * Magic method to conver the object to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
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
     * Set title
     *
     * @param string $title Title
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Set uri
     *
     * @param string $uri URI
     *
     * @return void
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set slug
     *
     * @param string $slug Slug
     *
     * @return void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * Set date
     *
     * @param datetime $date Date
     *
     * @return void
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set annotation
     *
     * @param text $annotation Annotation
     *
     * @return void
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * Get annotation
     *
     * @return text
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * Set content
     *
     * @param text $content Content
     *
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy Created By
     *
     * @return void
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt Created At
     *
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedBy
     *
     * @param integer $updatedBy Updated By
     *
     * @return void
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * Get updatedBy
     *
     * @return integer
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt Updated At
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set subscription
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Subscription $subscription Subscription object
     *
     * @return void
     */
    public function setSubscription(\Gpupo\CamelSpiderBundle\Entity\Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get subscription
     *
     * @return Gpupo\CamelSpiderBundle\Entity\Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set rawnews
     *
     * @param Gpupo\CamelSpiderBundle\Entity\RawNews $rawnews Raw news
     *
     * @return void
     */
    public function setRawnews(\Gpupo\CamelSpiderBundle\Entity\RawNews $rawnews)
    {
        $this->rawnews = $rawnews;
    }

    /**
     * Get rawnews
     *
     * @return Gpupo\CamelSpiderBundle\Entity\RawNews
     */
    public function getRawnews()
    {
        return $this->rawnews;
    }

    /**
     * Add tags
     *
     * @param Gpupo\CamelSpiderBundle\Entity\NewsTag $tags Tags array
     *
     * @return void
     */
    public function addNewsTag(\Gpupo\CamelSpiderBundle\Entity\NewsTag $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set moderation
     *
     * @param string $moderation
     */
    public function setModeration($moderation)
    {
        $this->moderation = $moderation;
    }

    /**
     * Get moderation
     *
     * @return string
     */
    public function getModeration()
    {
        return $this->moderation;
    }


    /**
     * Set category
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Category $category
     */
    public function setCategory(\Gpupo\CamelSpiderBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Gpupo\CamelSpiderBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}