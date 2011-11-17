<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Funpar\AdminBundle\Entity\User as User;

/**
 * Gpupo\CamelSpiderBundle\Entity\NewsVote
 *
 * @ORM\Table(name="news_vote")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\NewsVoteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class NewsVote
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
     * @var string $value
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="votes", cascade={"all"})
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     */
    private $news;

    /**
     * @ORM\ManyToOne(targetEntity="\Funpar\AdminBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Set value
     *
     * @param integer $value
     */
    public function setValue($value)
    {
       $value = intval($value);

        if ($value < 1 || $value > 5 ) {
            throw new \InvalidArgumentException('A vote must be between 1 and 5');
        }

        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set news
     *
     * @param Gpupo\CamelSpiderBundle\Entity\News $news
     */
    public function setNews(\Gpupo\CamelSpiderBundle\Entity\News $news)
    {
        $this->news = $news;
    }

    /**
     * Get news
     *
     * @return Gpupo\CamelSpiderBundle\Entity\News
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set user
     *
     * @param Funpar\AdminBundle\Entity\User $user
     */
    public function setUser(\Funpar\AdminBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Funpar\AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}