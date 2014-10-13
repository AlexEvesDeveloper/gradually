<?php

namespace Gradually\UtilBundle\Entity;

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
     * @ORM\OneToOne(targetEntity="RecruiterUser")
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
     * @ORM\Column(name="location_string", type="string", length=64)
     */
    private $locationString;

    /**
     * @ORM\Column(name="distance", type="integer", nullable=true)
     */
    private $distance;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param RecruiterUser $recruiter
     * @return JobSearch
     */
    public function setRecruiter(RecruiterUser $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return RecruiterUser
     */
    public function getRecruiter()
    {
        return $this->recruiter;
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
     * Set locationString
     *
     * @param string $locationString
     * @return JobSearch
     */
    public function setLocationString($locationString)
    {
        $this->locationString = $locationString;

        return $this;
    }

    /**
     * Get locationString
     *
     * @return string 
     */
    public function getLocationString()
    {
        return $this->locationString;
    }
}
