<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gpupo\CamelSpiderBundle\Entity\NewsSource
 *
 * @ORM\Table(name="raw_news")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\RawNewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class RawNews
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
     * @var string $relevation
     *
     * @ORM\Column(name="relevation", type="integer")
     */
    private $relevation;

    /**
     * @var datetime $date
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var text $rawdata
     *
     * @ORM\Column(name="rawdata", type="text")
     */
    private $rawdata;

    /**
     * @var text $html
     *
     * @ORM\Column(name="html", type="text")
     */
    private $html;

    /**
     * @var text $txt
     *
     * @ORM\Column(name="txt", type="text")
     */
    private $txt;

    /**
     * @ORM\OneToOne(targetEntity="Subscription")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     */
    private $subscription;

    /**
     * @var datetime $created_by
     *
     * @ORM\Column(name="created_by", type="integer", nullable=true)
     */
    private $created_by;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var integer $updated_by
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    private $updated_by;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (!$this->getId()) {
            $this->created_at = new \DateTime(date('Y-m-d H:m:s'));
        }
        $this->updated_at = new \DateTime(date('Y-m-d H:m:s'));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated_at = new \DateTime(date('Y-m-d H:m:s'));
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
     * @param string $title
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
     * @param string $uri
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
     * Set relevation
     *
     * @param integer $relevation
     */
    public function setRelevation($relevation)
    {
        $this->relevation = $relevation;
    }

    /**
     * Get relevation
     *
     * @return integer 
     */
    public function getRelevation()
    {
        return $this->relevation;
    }

    /**
     * Set date
     *
     * @param datetime $date
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
     * Set rawdata
     *
     * @param text $rawdata
     */
    public function setRawdata($rawdata)
    {
        $this->rawdata = $rawdata;
    }

    /**
     * Get rawdata
     *
     * @return text 
     */
    public function getRawdata()
    {
        return $this->rawdata;
    }

    /**
     * Set html
     *
     * @param text $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * Get html
     *
     * @return text 
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set txt
     *
     * @param text $txt
     */
    public function setTxt($txt)
    {
        $this->txt = $txt;
    }

    /**
     * Get txt
     *
     * @return text 
     */
    public function getTxt()
    {
        return $this->txt;
    }

    /**
     * Set created_by
     *
     * @param integer $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;
    }

    /**
     * Get created_by
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_by
     *
     * @param integer $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updated_by = $updatedBy;
    }

    /**
     * Get updated_by
     *
     * @return integer 
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set subscription
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Subscription $subscription
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
}