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
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=64)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=64)
     */
    private $lastName;
    
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
     * Set firstName
     *
     * @param string $firstName
     * @return GraduateProfile
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return GraduateProfile
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
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
}
