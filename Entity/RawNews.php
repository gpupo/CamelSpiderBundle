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
     * @var string $relevancy
     *
     * @ORM\Column(name="relevancy", type="integer")
     */
    private $relevancy;

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
     * Set relevancy
     *
     * @param integer $relevancy
     */
    public function setRelevancy($relevancy)
    {
        $this->relevancy = $relevancy;
    }

    /**
     * Get relevancy
     *
     * @return integer
     */
    public function getRelevancy()
    {
        return $this->relevancy;
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