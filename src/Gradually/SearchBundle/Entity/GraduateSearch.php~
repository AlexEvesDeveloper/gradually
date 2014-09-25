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
     * @ORM\Column(name="year_from", type="string", length=4, nullable=true)
     */
    private $yearFrom;

     /**
     * @ORM\Column(name="year_to", type="string", length=4, nullable=true)
     */
    private $yearTo;   

    /**
     * @ORM\Column(name="result_from", type="integer", nullable=true)
     */
    private $resultFrom;
   
    /**
     * @ORM\Column(name="result_to", type="integer", nullable=true)
     */
    private $resultTo;

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
     * Set yearFrom
     *
     * @param string $yearFrom
     * @return GraduateSearch
     */
    public function setYearFrom($yearFrom)
    {
        $this->yearFrom = $yearFrom;

        return $this;
    }

    /**
     * Get yearFrom
     *
     * @return string 
     */
    public function getYearFrom()
    {
        return $this->yearFrom;
    }

    /**
     * Set yearTo
     *
     * @param string $yearTo
     * @return GraduateSearch
     */
    public function setYearTo($yearTo)
    {
        $this->yearTo = $yearTo;

        return $this;
    }

    /**
     * Get yearTo
     *
     * @return string 
     */
    public function getYearTo()
    {
        return $this->yearTo;
    }

    /**
     * Set resultFrom
     *
     * @param integer $resultFrom
     * @return GraduateSearch
     */
    public function setResultFrom($resultFrom)
    {
        $this->resultFrom = $resultFrom;

        return $this;
    }

    /**
     * Get resultFrom
     *
     * @return integer 
     */
    public function getResultFrom()
    {
        return $this->resultFrom;
    }

    /**
     * Set resultTo
     *
     * @param integer $resultTo
     * @return GraduateSearch
     */
    public function setResultTo($resultTo)
    {
        $this->resultTo = $resultTo;

        return $this;
    }

    /**
     * Get resultTo
     *
     * @return integer 
     */
    public function getResultTo()
    {
        return $this->resultTo;
    }
}
