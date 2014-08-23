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
     * var \Gradually\GraduateBundle\Entity\Qualification
     *
     * @ORM\OneToMany(targetEntity="\Gradually\GraduateBundle\Entity\Qualification", mappedBy="graduate")
     */
    private $qualifications;

    /**
     * @ORM\ManyToMany(targetEntity="RecruiterProfile", inversedBy="graduates")
     */
    private $recruiters;

    /**
     * @ORM\ManyToMany(targetEntity="\Gradually\UtilBundle\Entity\University", mappedBy="graduates")
     */
    private $universities;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->qualifications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add qualifications
     *
     * @param \Gradually\ProfileBundle\Entity\Qualification $qualifications
     * @return GraduateProfile
     */
    public function addQualification(\Gradually\GraduateBundle\Entity\Qualification $qualifications)
    {
        $this->qualifications[] = $qualifications;

        return $this;
    }

    /**
     * Remove qualifications
     *
     * @param \Gradually\ProfileBundle\Entity\Qualification $qualifications
     */
    public function removeQualification(\Gradually\GraduateBundle\Entity\Qualification $qualifications)
    {
        $this->qualifications->removeElement($qualifications);
    }

    /**
     * Get qualifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }

   /**
     * Add recruiters
     *
     * @param \Gradually\ProfileBundle\Entity\RecruiterProfile $recruiters
     * @return GraduateProfile
     */
    public function addRecruiter(\Gradually\ProfileBundle\Entity\RecruiterProfile $recruiters)
    {
        $this->recruiters[] = $recruiters;

        return $this;
    }

    /**
     * Remove recruiters
     *
     * @param \Gradually\ProfileBundle\Entity\RecruiterProfile $recruiters
     */
    public function removeRecruiter(\Gradually\ProfileBundle\Entity\RecruiterProfile $recruiters)
    {
        $this->recruiters->removeElement($recruiters);
    }

    /**
     * Get recruiters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecruiters()
    {
        return $this->recruiters;
    }

    /**
     * Add universities
     *
     * @param \Gradually\UtilBundle\Entity\University $universities
     * @return GraduateProfile
     */
    public function addUniversity(\Gradually\UtilBundle\Entity\University $universities)
    {
        $this->universities[] = $universities;

        return $this;
    }

    /**
     * Remove universities
     *
     * @param \Gradually\UtilBundle\Entity\University $universities
     */
    public function removeUniversity(\Gradually\UtilBundle\Entity\University $universities)
    {
        $this->universities->removeElement($universities);
    }

    /**
     * Get universities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUniversities()
    {
        return $this->universities;
    }
}
