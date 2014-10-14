<?php

namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cv
 *
 * @ORM\Table(name="cvs")
 * @ORM\Entity
 */
class Cv
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

    /**
     * @ORM\OneToOne(targetEntity="GraduateUser", inversedBy="cv"))
     */
    private $graduate;

    /**
     * @ORM\OneToMany(targetEntity="Qualification", mappedBy="cv")
     */
    private $qualifications;

    /**
     * @ORM\OneToMany(targetEntity="Experience", mappedBy="cv")
     */
    private $experiences;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->qualifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->experiences = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set graduate
     *
     * @param \Gradually\UtilBundle\Entity\GraduateUser $graduate
     * @return Cv
     */
    public function setGraduate(\Gradually\UtilBundle\Entity\GraduateUser $graduate = null)
    {
        $this->graduate = $graduate;

        return $this;
    }

    /**
     * Get graduate
     *
     * @return \Gradually\UtilBundle\Entity\GraduateUser 
     */
    public function getGraduate()
    {
        return $this->graduate;
    }

    /**
     * Add qualifications
     *
     * @param \Gradually\UtilBundle\Entity\Qualification $qualifications
     * @return Cv
     */
    public function addQualification(\Gradually\UtilBundle\Entity\Qualification $qualifications)
    {
        $this->qualifications[] = $qualifications;

        return $this;
    }

    /**
     * Remove qualifications
     *
     * @param \Gradually\UtilBundle\Entity\Qualification $qualifications
     */
    public function removeQualification(\Gradually\UtilBundle\Entity\Qualification $qualifications)
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
     * Add experiences
     *
     * @param \Gradually\UtilBundle\Entity\Experience $experiences
     * @return Cv
     */
    public function addExperience(\Gradually\UtilBundle\Entity\Experience $experiences)
    {
        $this->experiences[] = $experiences;

        return $this;
    }

    /**
     * Remove experiences
     *
     * @param \Gradually\UtilBundle\Entity\Experience $experiences
     */
    public function removeExperience(\Gradually\UtilBundle\Entity\Experience $experiences)
    {
        $this->experiences->removeElement($experiences);
    }

    /**
     * Get experiences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExperiences()
    {
        return $this->experiences;
    }
}
