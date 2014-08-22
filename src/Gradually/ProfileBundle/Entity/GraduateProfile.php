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
}
