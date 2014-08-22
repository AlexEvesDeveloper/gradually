<?php

namespace Gradually\GraduateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qualification
 *
 * @ORM\Table(name="qualifications")
 * @ORM\Entity
 */
class Qualification
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
     * @var \Gradually\ProfileBundle\Entity\GraduateProfile
     *
     * @ORM\ManyToOne(targetEntity="\Gradually\ProfileBundle\Entity\GraduateProfile", inversedBy="qualifications")
     */
    private $graduate;

     /**
     * @var \Gradually\UtilBundle\Entity\University
     *
     * @ORM\ManyToOne(targetEntity="\Gradually\UtilBundle\Entity\University")
     */   
    private $university;

     /**
     * @var \Gradually\UtilBundle\Entity\Degree
     *
     * @ORM\ManyToOne(targetEntity="\Gradually\UtilBundle\Entity\Degree")
     */
    private $degree;

    /**
     * @var string
     *
     * @ORM\Column(name="result", type="string", length=16)
     */
    private $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="yearAttained", type="datetime")
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
     * Set result
     *
     * @param string $result
     * @return Qualification
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return string 
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set yearAttained
     *
     * @param \DateTime $yearAttained
     * @return Qualification
     */
    public function setYearAttained(\DateTime $yearAttained)
    {
        $this->yearAttained = $yearAttained;

        return $this;
    }

    /**
     * Get yearAttained
     *
     * @return \DateTime 
     */
    public function getYearAttained()
    {
        return $this->yearAttained;
    }

    /**
     * Set graduate
     *
     * @param \Gradually\ProfileBundle\Entity\GraduateProfile $graduate
     * @return Qualification
     */
    public function setGraduate(\Gradually\ProfileBundle\Entity\GraduateProfile $graduate = null)
    {
        $this->graduate = $graduate;

        return $this;
    }

    /**
     * Get graduate
     *
     * @return \Gradually\ProfileBundle\Entity\GraduateProfile
     */
    public function getGraduate()
    {
        return $this->graduate;
    }

    /**
     * Set university
     *
     * @param \Gradually\UtilBundle\Entity\University $university
     * @return Qualification
     */
    public function setUniversity(\Gradually\UtilBundle\Entity\University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university
     *
     * @return \Gradually\UtilBundle\Entity\University 
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * Set degree
     *
     * @param \Gradually\UtilBundle\Entity\Degree $degree
     * @return Qualification
     */
    public function setDegree(\Gradually\UtilBundle\Entity\Degree $degree = null)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return \Gradually\UtilBundle\Entity\Degree 
     */
    public function getDegree()
    {
        return $this->degree;
    }
}
