<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="registration_event")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RegistrationEventRepository")
 */
class RegistrationEvent
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
     * Time Groups
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TimeGroup", mappedBy="registrationEvent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $timeGroups;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="domain", type="string", length=255)
     */
    protected $domain;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="address", type="string", length=255)
     */
    protected $address;

    /**
     * @var City
     *
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    protected $city;

    /**
     * @var State
     *
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=false)
     */
    protected $state;

    /**
     * @var Country
     *
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    protected $country;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="postal_code", type="string", length=15)
     */
    protected $postalCode;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="venue", type="string", length=255)
     */
    protected $venue;

    /**
     * Registration Event date
     *
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_published", type="boolean")
     */
    protected $isPublished = false;


    public function __construct()
    {
        $this->timeGroups = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $domain
     * @return RegistrationEvent
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $address
     * @return RegistrationEvent
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $postalCode
     * @return RegistrationEvent
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $venue
     * @return RegistrationEvent
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return string
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param \DateTime $date
     * @return RegistrationEvent
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param boolean $isPublished
     * @return RegistrationEvent
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param TimeGroup $timeGroup
     * @return RegistrationEvent
     */
    public function addTimeGroup(TimeGroup $timeGroup)
    {
        $timeGroup->setRegistrationEvent($this);
        $this->timeGroups->add($timeGroup);

        return $this;
    }

    /**
     * @param TimeGroup $timeGroup
     */
    public function removeTimeGroup(TimeGroup $timeGroup)
    {
        $timeGroup->setRegistrationEvent(null);
        $this->timeGroups->removeElement($timeGroup);
    }

    /**
     * @return ArrayCollection
     */
    public function getTimeGroups()
    {
        return $this->timeGroups;
    }

    /**
     * @param City $city
     * @return RegistrationEvent
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param State $state
     * @return RegistrationEvent
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param Country $country
     * @return RegistrationEvent
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }
}
