<?php

namespace Gradually\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="jobs")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Job
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Gradually\ProfileBundle\Entity\RecruiterProfile", inversedBy="jobs")
     */
    private $recruiter;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="salaryFrom", type="decimal")
     */
    private $salaryFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="salaryTo", type="decimal")
     */
    private $salaryTo;

    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @var date
     *
     * @ORM\Column(name="updated", type="date")
     */
    private $updated;

    /**
     * @var date
     *
     * @ORM\Column(name="expires", type="date")
     */
    private $expires;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->isActive = true;
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
     * @return Job
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * Set description
     *
     * @param string $description
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set salaryFrom
     *
     * @param string $salaryFrom
     * @return Job
     */
    public function setSalaryFrom($salaryFrom)
    {
        $this->salaryFrom = $salaryFrom;

        return $this;
    }

    /**
     * Get salaryFrom
     *
     * @return string 
     */
    public function getSalaryFrom()
    {
        return $this->salaryFrom;
    }

    /**
     * Set salaryTo
     *
     * @param string $salaryTo
     * @return Job
     */
    public function setSalaryTo($salaryTo)
    {
        $this->salaryTo = $salaryTo;

        return $this;
    }

    /**
     * Get salaryTo
     *
     * @return string 
     */
    public function getSalaryTo()
    {
        return $this->salaryTo;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Job
     */
    public function setCreated(\DateTime $created = null)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     * @return Job
     */
    public function setExpires(\DateTime $expires = null)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime 
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Job
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
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
     * Set recruiter
     *
     * @param \Gradually\ProfileBundle\Entity\RecruiterProfile $recruiter
     * @return Job
     */
    public function setRecruiter(\Gradually\ProfileBundle\Entity\RecruiterProfile $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \Gradually\ProfileBundle\Entity\RecruiterProfile 
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Job
     */
    public function setUpdated(\DateTime $updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedDate()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedDate()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * @ORM\PrePersist
     */
    public function setExpiryDate()
    {
        $this->expires = new \DateTime("now");
        $this->expires->add(new \DateInterval('P30D')); 
    }
}