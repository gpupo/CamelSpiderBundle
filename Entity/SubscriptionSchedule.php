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
    private $time_schedule;

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
    private $is_active;



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
     * @param time $timeSchedule
     */
    public function setTimeSchedule($timeSchedule)
    {
        $this->time_schedule = $timeSchedule;
    }

    /**
     * Get time_schedule
     *
     * @return time
     */
    public function getTimeSchedule()
    {
        return $this->time_schedule;
    }

    /**
     * Set sun
     *
     * @param boolean $sun
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
     * @param boolean $mon
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
     * @param boolean $tue
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
     * @param boolean $wed
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
     * @param boolean $thu
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
     * @param boolean $fri
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
     * @param boolean $sat
     */
    public function setSat($sat)
    {
        $this->sat = $sat;
    }

    /**
     * Get sat
     *
     * @return boolean
     */
    public function getSat()
    {
        return $this->sat;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get is_active
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
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