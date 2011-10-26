<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule
 *
 * @ORM\Table(name="subscription_schedule")
 * @ORM\Entity(repositoryClass="Gpupo\CamelSpiderBundle\Entity\SubscriptionScheduleRepository")
 */
class SubscriptionSchedule
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
     * @var Subscription $subscription
     *
     * @ORM\ManyToOne(targetEntity="Subscription", inversedBy="schedules")
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id")
     *
     */
    private $subscription;

    /**
     * @var time $time_schedule
     *
     * @ORM\Column(name="schedule", type="time", nullable="true")
     */
    private $timeSchedule;

    /**
     * @var boolean $sun
     *
     * @ORM\Column(name="sun", type="boolean", nullable="true")
     */
    private $sun;

    /**
     * @var boolean $mon
     *
     * @ORM\Column(name="mon", type="boolean", nullable="true")
     */
    private $mon;

    /**
     * @var boolean $tue
     *
     * @ORM\Column(name="tue", type="boolean", nullable="true")
     */
    private $tue;

    /**
     * @var boolean $wed
     *
     * @ORM\Column(name="wed", type="boolean", nullable="true")
     */
    private $wed;

    /**
     * @var boolean $thu
     *
     * @ORM\Column(name="thu", type="boolean", nullable="true")
     */
    private $thu;

    /**
     * @var boolean $fri
     *
     * @ORM\Column(name="fri", type="boolean", nullable="true")
     */
    private $fri;

    /**
     * @var boolean $sat
     *
     * @ORM\Column(name="sat", type="boolean", nullable="true")
     */
    private $sat;

    /**
     * @var boolean $is_active
     *
     * @ORM\Column(name="is_active", type="boolean", nullable="true")
     */
    private $isActive;



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
     * Set time_schedule
     *
     * @param time $timeSchedule Time schedule
     *
     * @return void
     */
    public function setTimeSchedule($timeSchedule)
    {
        $this->timeSchedule = $timeSchedule;
    }

    /**
     * Get timeSchedule
     *
     * @return time
     */
    public function getTimeSchedule()
    {
        return $this->timeSchedule;
    }

    /**
     * Set sun
     *
     * @param boolean $sun Sunday value
     *
     * @return void
     */
    public function setSun($sun)
    {
        $this->sun = $sun;
    }

    /**
     * Get sun
     *
     * @return boolean
     */
    public function getSun()
    {
        return $this->sun;
    }

    /**
     * Set mon
     *
     * @param boolean $mon Monday value
     *
     * @return void
     */
    public function setMon($mon)
    {
        $this->mon = $mon;
    }

    /**
     * Get mon
     *
     * @return boolean
     */
    public function getMon()
    {
        return $this->mon;
    }

    /**
     * Set tue
     *
     * @param boolean $tue Tuesday value
     *
     * @return void
     */
    public function setTue($tue)
    {
        $this->tue = $tue;
    }

    /**
     * Get tue
     *
     * @return boolean
     */
    public function getTue()
    {
        return $this->tue;
    }

    /**
     * Set wed
     *
     * @param boolean $wed Wednesday value
     *
     * @return void
     */
    public function setWed($wed)
    {
        $this->wed = $wed;
    }

    /**
     * Get wed
     *
     * @return boolean
     */
    public function getWed()
    {
        return $this->wed;
    }

    /**
     * Set thu
     *
     * @param boolean $thu Thusday value
     *
     * @return void
     */
    public function setThu($thu)
    {
        $this->thu = $thu;
    }

    /**
     * Get thu
     *
     * @return boolean
     */
    public function getThu()
    {
        return $this->thu;
    }

    /**
     * Set fri
     *
     * @param boolean $fri Friday value
     *
     * @return void
     */
    public function setFri($fri)
    {
        $this->fri = $fri;
    }

    /**
     * Get fri
     *
     * @return boolean
     */
    public function getFri()
    {
        return $this->fri;
    }

    /**
     * Set sat
     *
     * @param boolean $sat Saturday value
     *
     * @return void
     */
    public function setSat($sat)
    {
        $this->sat = $sat;
    }

    /**
     * Get sat
     *
     * @return boolean Saturday value
     *
     * @return void
     */
    public function getSat()
    {
        return $this->sat;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive Is Active value
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
     * Set subscription
     *
     * @param Gpupo\CamelSpiderBundle\Entity\Subscription $subscription The subscription object
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
}