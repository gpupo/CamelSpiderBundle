<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use CamelSpider\Entity\AbstractSubscription;

/**
 * Gpupo\CamelSpiderBundle\Entity\NewsSource
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\SubscriptionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Subscription extends AbstractSubscription
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
     * @var string $uri
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * @var string $uri_login
     *
     * @ORM\Column(name="uri_login", type="string", length=255, nullable=true)
     */
    private $uri_login;

    /**
     * @var string $uri_password
     *
     * @ORM\Column(name="uri_password", type="string", length=255, nullable=true)
     */
    private $uri_password;

    /**
     * @var text $filters
     *
     * @ORM\Column(name="filters", type="text", nullable=true)
     */
    private $filters;

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
     * Set uri_login
     *
     * @param string $uriLogin
     */
    public function setUriLogin($uriLogin)
    {
        $this->uri_login = $uriLogin;
    }

    /**
     * Get uri_login
     *
     * @return string
     */
    public function getUriLogin()
    {
        return $this->uri_login;
    }

    /**
     * Set uri_password
     *
     * @param string $uriPassword
     */
    public function setUriPassword($uriPassword)
    {
        $this->uri_password = $uriPassword;
    }

    /**
     * Get uri_password
     *
     * @return string
     */
    public function getUriPassword()
    {
        return $this->uri_password;
    }

    /**
     * Set filters
     *
     * @param text $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Get filters
     *
     * @return text
     */
    public function getFilters()
    {
        return $this->filters;
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
}