<?php

namespace Gradually\ProfileBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * RecruiterProfile
 *
 * @ORM\Entity
 */

class RecruiterProfile extends Profile
{
	/**
     * @ORM\ManyToMany(targetEntity="GraduateProfile", mappedBy="recruiters")
     */
    private $graduates;

    /**
     * @ORM\OneToMany(targetEntity="\Gradually\JobBundle\Entity\Job", mappedBy="recruiter")
     */
    private $jobs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add graduates
     *
     * @param \Gradually\ProfileBundle\Entity\GraduateProfile $graduates
     * @return RecruiterProfile
     */
    public function addGraduate(\Gradually\ProfileBundle\Entity\GraduateProfile $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param \Gradually\ProfileBundle\Entity\GraduateProfile $graduates
     */
    public function removeGraduate(\Gradually\ProfileBundle\Entity\GraduateProfile $graduates)
    {
        $this->graduates->removeElement($graduates);
    }

    /**
     * Get graduates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGraduates()
    {
        return $this->graduates;
    }
}
