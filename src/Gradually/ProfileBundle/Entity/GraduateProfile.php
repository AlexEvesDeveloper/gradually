<?php

namespace Gradually\ProfileBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * GraduateProfile
 *
 * @ORM\Entity
 */

class GraduateProfile extends Profile
{
    /**
     * var \Gradually\GraduateBundle\Entity\University
     *
     * @ORM\ManyToOne(targetEntity="\Gradually\GraduateBundle\Entity\University", inversedBy="graduates")
     */
    private $university;

    /**
     * @var \Gradually\GraduateBundle\Entity\Degree
     *
     * @ORM\ManyToMany(targetEntity="\Gradually\GraduateBundle\Entity\Degree", inversedBy="graduates")
     */
    private $degrees;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->degrees = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set university
     *
     * @param \Gradually\GraduateBundle\Entity\University $university
     * @return GraduateProfile
     */
    public function setUniversity(\Gradually\GraduateBundle\Entity\University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university
     *
     * @return \Gradually\GraduateBundle\Entity\University 
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * Add degrees
     *
     * @param \Gradually\GraduateBundle\Entity\Degree $degrees
     * @return GraduateProfile
     */
    public function addDegree(\Gradually\GraduateBundle\Entity\Degree $degrees)
    {
        $this->degrees[] = $degrees;

        return $this;
    }

    /**
     * Remove degrees
     *
     * @param \Gradually\GraduateBundle\Entity\Degree $degrees
     */
    public function removeDegree(\Gradually\GraduateBundle\Entity\Degree $degrees)
    {
        $this->degrees->removeElement($degrees);
    }

    /**
     * Get degrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDegrees()
    {
        return $this->degrees;
    }
}
