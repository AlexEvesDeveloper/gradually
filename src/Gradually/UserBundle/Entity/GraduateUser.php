<?php
 
namespace Gradually\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GraduateUser
 *
 * @ORM\Entity
 */
class GraduateUser extends User
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=64)
     */
    protected $firstName;
 
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=64)
     */
    protected $lastName;

    /**
     * var \Gradually\GraduateBundle\Entity\Qualification
     *
     * @ORM\OneToMany(targetEntity="\Gradually\GraduateBundle\Entity\Qualification", mappedBy="graduate")
     */
    private $qualifications;

    /**
     * @ORM\ManyToMany(targetEntity="RecruiterUser", inversedBy="graduates")
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
        parent::__construct();
        $this->qualifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recruiters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->universities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return GraduateUser
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
     * @return GraduateUser
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
     * Add qualifications
     *
     * @param \Gradually\GraduateBundle\Entity\Qualification $qualifications
     * @return GraduateUser
     */
    public function addQualification(\Gradually\GraduateBundle\Entity\Qualification $qualifications)
    {
        $this->qualifications[] = $qualifications;

        return $this;
    }

    /**
     * Remove qualifications
     *
     * @param \Gradually\GraduateBundle\Entity\Qualification $qualifications
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

    /**
     * Add universities
     *
     * @param \Gradually\UtilBundle\Entity\University $universities
     * @return GraduateUser
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

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return parent::TYPE_GRADUATE;
    }
}
