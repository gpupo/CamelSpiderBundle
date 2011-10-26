<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\OneToOne(targetEntity="News")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     */
    private $news;

}