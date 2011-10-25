<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule;
use CamelSpider\Entity\InterfaceSubscription;


/**
 * Gpupo\CamelSpiderBundle\Entity\Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\SubscriptionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Subscription implements InterfaceSubscription
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
     * @var string $source_type
     *
     * @ORM\Column(name="source_type", type="string", length=10)
     */
    private $source_type;

    /**
     * @var string $source_domain
     *
     * @ORM\Column(name="source_domain", type="string", length=255)
     */
    private $source_domain;

    /**
     * @var string $auth_info
     *
     * @ORM\Column(name="auth_info", type="string", length=255, nullable=true)
     */
    private $auth_info;

    /**
     * @var string $uri_target
     *
     * @ORM\Column(name="uri_target", type="string", length=255)
     */
    private $uri_target;

    /**
     * @var string $max_depth
     *
     * @ORM\Column(name="max_depth", type="integer")
     */
    private $max_depth;

    /**
     * @var text $filters_contain
     *
     * @ORM\Column(name="filters_contain", type="text", nullable=true)
     */
    private $filters_contain;

    /**
     * @var text $filters_not_contain
     *
     * @ORM\Column(name="filters_not_contain", type="text", nullable=true)
     */
    private $filters_not_contain;

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
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SubscriptionSchedule", mappedBy="subscription", cascade={"all"})
     */
    private $schedules;

    private $status;

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
//    public function __toString()
//    {
//        return (string) $this->getName();
//    }

    /**
     * Add schedules
     *
     * @param Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule $schedule
     */
    public function addSubscriptionSchedule(\Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule $schedules)
    {
        $this->schedules[] = $schedules;
        $schedules->setSubscription($this);
    }

    /**
     * Get schedules
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * Set schedules
     *
     */
    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
        foreach ($schedules as $schedule){
            $schedule->setSubscription($this);
        }

    }
    public function __construct()
    {
        $this->schedules = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set source_type
     *
     * @param string $sourceType
     */
    public function setSourceType($sourceType)
    {
        $this->source_type = $sourceType;
    }

    /**
     * Get source_type
     *
     * @return string
     */
    public function getSourceType()
    {
        return $this->source_type;
    }

    /**
     * Set source_domain
     *
     * @param string $sourceDomain
     */
    public function setSourceDomain($sourceDomain)
    {
        $this->source_domain = $sourceDomain;
    }

    /**
     * Get source_domain
     *
     * @return string
     */
    public function getSourceDomain()
    {
        return $this->source_domain;
    }
    /**
     * Set auth_info
     *
     * @param string $authInfo
     */
    public function setAuthInfo($authInfo)
    {
        $this->auth_info = $authInfo;
    }

    /**
     * Get auth_info
     *
     * @return string
     */
    public function getAuthInfo()
    {
        return $this->auth_info;
    }

    /**
     * Set uri_target
     *
     * @param string $uriTarget
     */
    public function setUriTarget($uriTarget)
    {
        $this->uri_target = $uriTarget;
    }

    /**
     * Get uri_target
     *
     * @return string
     */
    public function getUriTarget()
    {
        return $this->uri_target;
    }

    /**
     * Set max_depth
     *
     * @param integer $maxDepth
     */
    public function setMaxDepth($maxDepth)
    {
        $this->max_depth = $maxDepth;
    }

    /**
     * Get max_depth
     *
     * @return integer
     */
    public function getMaxDepth()
    {
        return $this->max_depth;
    }

    /**
     * Set filters_contain
     *
     * @param text $filtersContain
     */
    public function setFiltersContain($filtersContain)
    {
        $this->filters_contain = $filtersContain;
    }

    /**
     * Get filters_contain
     *
     * @return text
     */
    public function getFiltersContain()
    {
        return $this->filters_contain;
    }

    /**
     * Set filters_not_contain
     *
     * @param text $filtersNotContain
     */
    public function setFiltersNotContain($filtersNotContain)
    {
        $this->filters_not_contain = $filtersNotContain;
    }

    /**
     * Get filters_not_contain
     *
     * @return text
     */
    public function getFiltersNotContain()
    {
        return $this->filters_not_contain;
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


    /* Implementing interface */

    public function __toString()
    {
        return $this->getName();
    }


    public function setStatus($x)
    {
        return $this->status = $x;
    }

    private function _explode($x, $sep=',')
    {
        if(strpos($sep, $x) === true) {
            return explode($sep, $x);
        }
        else
        {
            return array($x);
        }
    }

    public function getDomain()
    {
        return $this->_explode($this->getSourceDomain());
    }

    public function getHref()
    {
        return $this->getUriTarget();
    }

    public function getFilters()
    {
        return $this->get('filters');
    }

    /**
     * @param string $type contain|notContain
     */
    public function getFilter($type)
    {
        switch ($type) {
            case 'not_contain':
            case 'not contain':
            case 'notcontain':
                return $this->_explode($this->getFiltersNotContain(), PHP_EOL);
                break;

            case 'contain':
            default:
                return $this->_explode($this->getFiltersContain(), PHP_EOL);
                break;
        }
    }

    public function getDomainString()
    {
        return implode(',', $this->getDomain());
    }

    public function getLink($sha1)
    {
        //make somethin cool with your DB!
        return false;
    }

    public function isDone()
    {
        return true;
    }

    public function isWaiting()
    {
        return false;
    }

    public function toMinimal()
    {
        return $this;
    }

    protected function inDomain($str)
    {
        foreach($this->getSourceDomain() as $domain)
        {
            if(stripos($str, $domain))
            {
                    return true;
            }
        }
    }

    public function insideScope(Link $link)
    {
        if (
            substr($link->get('href'), 0, 4) == 'http' &&
            !$this->inDomain($link->get('href'))
        ) {
            return false;
        }

        return true;
    }


}