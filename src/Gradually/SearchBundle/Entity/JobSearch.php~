<?php

namespace Gradually\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobSearch
 *
 * @ORM\Table(name="job_searches")
 * @ORM\Entity
 */
class JobSearch
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
     * @ORM\OneToOne(targetEntity="\Gradually\UserBundle\Entity\RecruiterUser")
     */
    private $recruiter;

    /**
     * @ORM\Column(name="keywords", type="string", length=256, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(name="salary_from", type="integer", nullable=true)
     */
    private $salaryFrom;

    /**
     * @ORM\Column(name="salary_to", type="integer", nullable=true)
     */
    private $salaryTo;

    /**
     * @ORM\OneToMany(targetEntity="\Gradually\JobBundle\Entity\Location", mappedBy="jobSearch")
     */
    private $location;

    /**
     * @ORM\Column(name="distance", type="text", length=16, nullable=true)
     */
    private $distance;

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
     * Set keywords
     *
     * @param string $keywords
     * @return JobSearch
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set salaryFrom
     *
     * @param integer $salaryFrom
     * @return JobSearch
     */
    public function setSalaryFrom($salaryFrom)
    {
        $this->salaryFrom = $salaryFrom;

        return $this;
    }

    /**
     * Get salaryFrom
     *
     * @return integer 
     */
    public function getSalaryFrom()
    {
        return $this->salaryFrom;
    }

    /**
     * Set salaryTo
     *
     * @param integer $salaryTo
     * @return JobSearch
     */
    public function setSalaryTo($salaryTo)
    {
        $this->salaryTo = $salaryTo;

        return $this;
    }

    /**
     * Get salaryTo
     *
     * @return integer 
     */
    public function getSalaryTo()
    {
        return $this->salaryTo;
    }

    /**
     * Set recruiter
     *
     * @param \Gradually\UserBundle\Entity\RecruiterUser $recruiter
     * @return JobSearch
     */
    public function setRecruiter(\Gradually\UserBundle\Entity\RecruiterUser $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \Gradually\UserBundle\Entity\RecruiterUser
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return JobSearch
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set distance
     *
     * @param string $distance
     * @return JobSearch
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return string 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Add location
     *
     * @param \Gradually\JobBundle\Entity\Location $location
     * @return JobSearch
     */
    public function addLocation(\Gradually\JobBundle\Entity\Location $location)
    {
        $this->location[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \Gradually\JobBundle\Entity\Location $location
     */
    public function removeLocation(\Gradually\JobBundle\Entity\Location $location)
    {
        $this->location->removeElement($location);
    }
}
