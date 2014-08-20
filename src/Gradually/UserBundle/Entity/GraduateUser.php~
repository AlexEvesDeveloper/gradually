<?php
 
namespace Gradually\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * GraduateUser
 *
 * @ORM\Entity
 */
class GraduateUser extends User
{
    /**
     * @ORM\ManyToMany(targetEntity="RecruiterUser", inversedBy="graduates")
     */
    private $recruiters;

    public function __construct()
    {
        $this->recruiters = new ArrayCollection();
    }

    /**
     * Add recruiters
     *
     * @param \Gradually\UserBundle\Entity\RecruiterUser $recruiters
     * @return GraduateUser
     */
    public function addRecruiter(\Gradually\UserBundle\Entity\RecruiterUser $recruiters)
    {
        $this->recruiters[] = $recruiters;

        return $this;
    }

    /**
     * Remove recruiters
     *
     * @param \Gradually\UserBundle\Entity\RecruiterUser $recruiters
     */
    public function removeRecruiter(\Gradually\UserBundle\Entity\RecruiterUser $recruiters)
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
