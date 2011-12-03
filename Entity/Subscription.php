<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PSS\Bundle\DoctrineExtensionsBundle\Annotation as PSS;
use Symfony\Component\Validator\Constraints as Assert;
use Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule;
use CamelSpider\Entity\InterfaceSubscription;
use CamelSpider\Entity\Link;
use Funpar\AdminBundle\Entity\Log;

/**
 * Gpupo\CamelSpiderBundle\Entity\Subscription
 *
 * @ORM\Table(name="subscription")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\SubscriptionRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @PSS\Blameable(creator="createdBy", updater="updatedBy")
 */
class Subscription implements InterfaceSubscription
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
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
    private $sourceType;

    /**
     * @var string $source_domain
     *
     * @ORM\Column(name="source_domain", type="string", length=255)
     */
    private $sourceDomain;

    /**
     * @var string $href
     *
     * @ORM\Column(name="href", type="string", length=255)
     */
    private $href;

    /**
     * @var string $auth_info
     *
     * @ORM\Column(name="auth_info", type="string", length=255, nullable=true)
     */
    private $authInfo;

    /**
     * @var string $uri_target
     *
     * @ORM\Column(name="uri_target", type="string", length=255, nullable=true)
     */
    private $uriTarget;

    /**
     * @var string $max_depth
     *
     * @ORM\Column(name="max_depth", type="integer")
     */
    private $maxDepth;

    /**
     * @var text $filters_contain
     *
     * @ORM\Column(name="filters_contain", type="text", nullable=true)
     */
    private $filtersContain;

    /**
     * @var text $filters_not_contain
     *
     * @ORM\Column(name="filters_not_contain", type="text", nullable=true)
     */
    private $filtersNotContain;

    /**
     * @var string $format
     *
     * @ORM\Column(name="format", type="string", length=255, nullable=true)
     */
    private $format;

    /**
     * @var string $encoding
     *
     * @ORM\Column(name="encoding", type="string", length=255, nullable=true)
     */
    private $encoding;

    /**
     * @var integer $createdBy
     *
     * @ORM\ManyToOne(targetEntity="\Funpar\AdminBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    private $createdBy;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var integer $updatedBy
     *
     * @ORM\ManyToOne(targetEntity="\Funpar\AdminBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    private $updatedBy;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var datetime $isActive
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="SubscriptionSchedule", mappedBy="subscription", cascade={"all"})
     */
    private $schedules;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Funpar\AdminBundle\Entity\Log", mappedBy="subscription", cascade={"all"})
     */
    private $logs;

    /**
     * Not stored status
     * @var string
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subscriptions")
     */
    private $category;

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
     * Set schedules
     *
     * @param array $schedules Array of schedules
     *
     * @return void
     */
    public function setSchedules($schedules)
    {
        $this->schedules = $schedules;
        foreach ($schedules as $schedule) {
            $schedule->setSubscription($this);
        }
    }

    /**
     * The class constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->schedules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @param string $mode interger or string
     * @return integer default but can return string for Pool colllection
     */
    public function getId($mode='integer')
    {
        if ($mode == 'string') {
            return $this->getHash();
        } else {
            return $this->id;
        }
    }

    /**
     * Get sha1 for Zend_Cache key
     *
     * @return string
     */
    public function getHash()
    {
        return sha1($this->getHref());
    }


    /**
     * Set name
     *
     * @param string $name Name of subscription
     *
     * @return void
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
     * @param string $sourceType The Source Type
     *
     * @return void
     */
    public function setSourceType($sourceType)
    {
        $this->sourceType = $sourceType;
    }

    /**
     * Get sourceType
     *
     * @return string
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * Set sourceDomain
     *
     * @param string $sourceDomain The Source Domain
     *
     * @return void
     */
    public function setSourceDomain($sourceDomain)
    {
        $this->sourceDomain = $sourceDomain;
    }

    /**
     * Get sourceDomain
     *
     * @return string
     */
    public function getSourceDomain()
    {
        return $this->sourceDomain;
    }
    /**
     * Set auth_info
     *
     * @param string $authInfo The auth info
     *
     * @return void
     */
    public function setAuthInfo($authInfo)
    {
        $this->authInfo = $authInfo;
    }

    /**
     * Get authInfo
     *
     * @return string
     */
    public function getAuthInfo()
    {
        return $this->authInfo;
    }

    /**
     * Set uriTarget
     *
     * @param string $uriTarget The uri target
     *
     * @return void
     */
    public function setUriTarget($uriTarget)
    {
        $this->uriTarget = $uriTarget;
    }

    /**
     * Get uriTarget
     *
     * @return string
     */
    public function getUriTarget()
    {
        return $this->uriTarget;
    }

    /**
     * Set maxDepth
     *
     * @param integer $maxDepth The max depth
     *
     * @return void
     */
    public function setMaxDepth($maxDepth)
    {
        $this->maxDepth = $maxDepth;
    }

    /**
     * Get maxDepth
     *
     * @return integer
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * Set filtersDontain
     *
     * @param text $filtersContain The filters contain
     *
     * @return void
     */
    public function setFiltersContain($filtersContain)
    {
        $this->filtersContain = $filtersContain;
    }

    /**
     * Get filtersContain
     *
     * @return text
     */
    public function getFiltersContain()
    {
        return $this->filtersContain;
    }

    /**
     * Set filtersNotNontain
     *
     * @param text $filtersNotContain The filters NOT contain
     *
     * @return void
     */
    public function setFiltersNotContain($filtersNotContain)
    {
        $this->filtersNotContain = $filtersNotContain;
    }

    /**
     * Get filtersNotContain
     *
     * @return text
     */
    public function getFiltersNotContain()
    {
        return $this->filtersNotContain;
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
     * Set isActive
     *
     * @param boolean $isActive Boolean true or false
     *
     * @return void
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set href
     *
     * @param string $href
     *
     * @return void
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * Get Href
     *
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActiveFormated()
    {
        return $this->isActive ? 'Yes' : 'No';
    }



    /* Implementing interface */

    /**
     * Default return to the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set the status
     *
     * @param string $x The status of the subscription
     *
     * @return void
     */
    public function setStatus($x)
    {
        return $this->status = $x;
    }

    /**
     * normalize espaces after commas
     *
     * @param string $x   String to explode
     *
     * @return string
     */
    public function normalize($x)
    {
        $i = 0;

        $x = str_replace(PHP_EOL, ',', $x);
        $x = str_replace(array("\r", "\r\n", "\n"), '', $x);
        while ($i < 10) {
            $x = str_replace('  ', ' ',  $x);
            $i++;
        }
        $x = trim(str_replace(array(' ,', ', '), ',',  $x));

        return $x;
    }

    /**
     * Returns an array from a value by exploding
     *
     * @param string $x   String to explode
     * @param string $sep The separator (default to comma)
     *
     * @return array
     */
    public function _explode($x, $sep=',')
    {
        if (is_null($x)) {
            return null;
        }

        $x = trim($x);
        if (strpos($x, $sep) === false && strpos($x, PHP_EOL) === false) {
            return array($x); //only one string;
        } else {
            return explode($sep, $this->normalize($x));
        }
    }

    /**
     * Get the domain in array
     *
     * @return array
     */
    public function getDomain()
    {
        return $this->_explode($this->getSourceDomain());
    }

    /**
     * Get the filters array
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            'contain'     => $this->getFilter('contain'),
            'notCcontain' => $this->getFilter('notCcontain'),
        );


    }

    /**
     * Returns the filter by type
     *
     * @param string $type contain|notContain
     *
     * @return array
     */
    public function getFilter($type)
    {
        switch ($type) {
            case 'not_contain':
            case 'not contain':
            case 'notcontain':
            case 'notContain':
                return $this->_explode($this->getFiltersNotContain());
                break;

            case 'contain':
            default:
                return $this->_explode($this->getFiltersContain());
                break;
        }
    }

    /**
     * Get Domain string
     *
     * @return string
     */
    public function getDomainString()
    {
        return $this->getSourceDomain();
    }

    /**
     * Get the link by Hash
     *
     * @param string $sha1 Link Hash
     *
     * @return string
     */
    public function getLink($sha1)
    {
        //make somethin cool with your DB!
        return false;
    }

    /**
     * Check if work is done
     *
     * @return boolean
     */
    public function isDone()
    {
        return true;
    }

    /**
     * Check if work is waiting
     *
     * @return boolean
     */
    public function isWaiting()
    {
        return false;
    }

    /**
     * Return toMinimal
     *
     * @return Gpupo\CamelSpiderBundle\Entity\Subscription
     */
    public function toMinimal()
    {
        return $this;
    }

    /**
     * Check if the domain exists in Source Domain
     *
     * @param strings $str Domain to check
     *
     * @return boolean
     */
    protected function inDomain($str)
    {
        if (current($this->getDomain()) == '*') {
            return true;//wildcard
        }

        foreach ($this->getDomain() as $domain) {
            if (stripos($str, $domain)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Inside Scope
     *
     * @param Link $link The link object
     *
     * @return CamelSpider\Entity\Link
     */
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


    public function get($name)
    {
        switch ($name) {
            case 'href':
                return $this->getHref();
                break;

            case 'domain':
                return $this->getDomain();
                break;

            default:
                return null;
                break;
        }
    }

    public function set($name, $value)
    {
        $this->$name = $value;
    }



    /**
     * Set format
     *
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set encoding
     *
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * Get encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
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

    /**
     * Add schedules
     *
     * @param Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule $schedules
     */
    public function addSubscriptionSchedule(\Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule $schedules)
    {
        $this->schedules[] = $schedules;
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
     * Add logs
     *
     * @param Funpar\AdminBundle\Entity\Log $logs
     */
    public function addLog(\Funpar\AdminBundle\Entity\Log $logs)
    {
        $this->logs[] = $logs;
    }

    /**
     * Get logs
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set updatedBy
     *
     * @param integer $updatedBy
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
     * Set createdBy
     *
     * @param Funpar\AdminBundle\Entity\User $createdBy
     */
    public function setCreatedBy(\Funpar\AdminBundle\Entity\User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Get createdBy
     *
     * @return Funpar\AdminBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
