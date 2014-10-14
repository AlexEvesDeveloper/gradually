<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qualification
 *
 * @ORM\Table(name="qualifications", indexes={
 *   @ORM\Index(name="year_attained", columns={"year_attained"})
 * })
 * @ORM\Entity
 */
class Qualification
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cv", inversedBy="qualifications")
     */
    private $cv;

    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="qualifications")
     */
    private $school;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="qualifications")
     */  
    private $course;

    /**
     * @ORM\Column(name="course_level", type="string", length=32)
     */   
    private $courseLevel;

    /**
     * @ORM\Column(name="grade", type="string", length=32)
     */   
    private $grade;

    /**
     * @ORM\Column(name="year_attained", type="smallint")
     */
    private $yearAttained;

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
     * Set school
     *
     * @param string $school
     * @return Qualification
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set course
     *
     * @param string $course
     * @return Qualification
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set courseLevel
     *
     * @param string $courseLevel
     * @return Qualification
     */
    public function setCourseLevel($courseLevel)
    {
        $this->courseLevel = $courseLevel;

        return $this;
    }

    /**
     * Get courseLevel
     *
     * @return string 
     */
    public function getCourseLevel()
    {
        return $this->courseLevel;
    }

    /**
     * Set grade
     *
     * @param string $grade
     * @return Qualification
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set yearAttained
     *
     * @param integer $yearAttained
     * @return Qualification
     */
    public function setYearAttained($yearAttained)
    {
        $this->yearAttained = $yearAttained;

        return $this;
    }

    /**
     * Get yearAttained
     *
     * @return integer 
     */
    public function getYearAttained()
    {
        return $this->yearAttained;
    }

    /**
     * Set cv
     *
     * @param \Gradually\UtilBundle\Entity\Cv $cv
     * @return Qualification
     */
    public function setCv(\Gradually\UtilBundle\Entity\Cv $cv = null)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get cv
     *
     * @return \Gradually\UtilBundle\Entity\Cv
     */
    public function getCv()
    {
        return $this->cv;
    }
}
