<?php

namespace Gradually\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GraduateSearch
 *
 * @ORM\Table(name="graduate_searches")
 * @ORM\Entity
 */
class GraduateSearch
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
     * @ORM\OneToOne(targetEntity="\Gradually\UtilBundle\Entity\University")
     */
    private $university;

    /**
     * @ORM\OneToOne(targetEntity="\Gradually\UtilBundle\Entity\Degree")
     */
    private $degree;

    /**
     * @ORM\Column(name="year_attained", type="string", length=4)
     */
    private $yearAttained;

    /**
     * @ORM\Column(name="result", type="string", length=3)
     */
    private $result;
   
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
     * Set university
     *
     * @param \Gradually\UtilBundle\Entity\University $university
     * @return GraduateSearch
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
     * @return GraduateSearch
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

    /**
     * Set yearAttained
     *
     * @param string $yearAttained
     * @return GraduateSearch
     */
    public function setYearAttained($yearAttained)
    {
        $this->yearAttained = $yearAttained;

        return $this;
    }

    /**
     * Get yearAttained
     *
     * @return string 
     */
    public function getYearAttained()
    {
        return $this->yearAttained;
    }

    /**
     * Set result
     *
     * @param string $result
     * @return GraduateSearch
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
}
