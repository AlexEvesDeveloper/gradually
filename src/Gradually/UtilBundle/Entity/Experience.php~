<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Experience
 *
 * @ORM\Table(name="experiences")
 * @ORM\Entity
 */
class Experience
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cv", inversedBy="experiences")
     */
    private $cv;

    /**
     * @ORM\Column(name="company", type="string", length=128)
     */   
    private $company;

    /**
     * @ORM\Column(name="year_from", type="smallint")
     */
    private $yearFrom;

    /**
     * @ORM\Column(name="year_to", type="smallint")
     */
    private $yearTo;

    /**
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

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
     * Set company
     *
     * @param string $company
     * @return Experience
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set yearFrom
     *
     * @param integer $yearFrom
     * @return Experience
     */
    public function setYearFrom($yearFrom)
    {
        $this->yearFrom = $yearFrom;

        return $this;
    }

    /**
     * Get yearFrom
     *
     * @return integer 
     */
    public function getYearFrom()
    {
        return $this->yearFrom;
    }

    /**
     * Set yearTo
     *
     * @param integer $yearTo
     * @return Experience
     */
    public function setYearTo($yearTo)
    {
        $this->yearTo = $yearTo;

        return $this;
    }

    /**
     * Get yearTo
     *
     * @return integer 
     */
    public function getYearTo()
    {
        return $this->yearTo;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Experience
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set cv
     *
     * @param \Gradually\UtilBundle\Entity\Cv $cv
     * @return Experience
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
