<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="time_group")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TimeGroupRepository")
 */
class TimeGroup
{
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="RegistrationEvent")
     * @ORM\JoinColumn(name="registration_event_id", referencedColumnName="id")
     */
    protected $registrationEvent;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="time", type="time")
     */
    protected $time;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="capacity", type="integer", length=11)
     */
    protected $capacity;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="amount", type="integer", length=11)
     */
    protected $amount = 0;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $time
     * @return TimeGroup
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param integer $capacity
     * @return TimeGroup
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return integer
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param integer $amount
     * @return TimeGroup
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param RegistrationEvent $registrationEvent
     * @return TimeGroup
     */
    public function setRegistrationEvent(RegistrationEvent $registrationEvent = null)
    {
        $this->registrationEvent = $registrationEvent;

        return $this;
    }

    /**
     * @return RegistrationEvent
     */
    public function getRegistrationEvent()
    {
        return $this->registrationEvent;
    }
}
