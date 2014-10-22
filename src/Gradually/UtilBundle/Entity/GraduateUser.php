<?php
 
namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * GraduateUser
 *
 * @ORM\Entity(repositoryClass="Gradually\UtilBundle\Repository\GraduateUserRepository")
 *
 * @ExclusionPolicy("all")
 */
class GraduateUser extends User
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=64)
     *
     * @Expose
     */
    protected $firstName;
 
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=64)
     *
     * @Expose
     */
    protected $lastName;

    /**
     * @ORM\OneToOne(targetEntity="Cv", mappedBy="graduate")
     */
    private $cv;

    /**
     * @ORM\ManyToMany(targetEntity="RecruiterUser", inversedBy="graduates")
     */
    private $recruiters;

    /**
     * @ORM\ManyToMany(targetEntity="JobTitle", mappedBy="graduates")
     *
     * @Expose
     */
    private $jobTitles;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="graduate") 
     */
    private $applications;

    /**
     * @var string
     *
     * @ORM\Column(name="notification_method", type="string", length=16)
     *
     * @Expose
     */
    private $notificationMethod;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->recruiters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->applications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobTitles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add recruiters
     *
     * @param RecruiterUser $recruiters
     * @return GraduateUser
     */
    public function addRecruiter(RecruiterUser $recruiters)
    {
        $this->recruiters[] = $recruiters;

        return $this;
    }

    /**
     * Remove recruiters
     *
     * @param RecruiterUser $recruiters
     */
    public function removeRecruiter(RecruiterUser $recruiters)
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
     * Add applications
     *
     * @param Application $applications
     * @return GraduateUser
     */
    public function addApplication(Application $applications)
    {
        $this->applications[] = $applications;

        return $this;
    }

    /**
     * Remove applications
     *
     * @param Application $applications
     */
    public function removeApplication(Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set notificationMethod
     *
     * @param string $notificationMethod
     * @return GraduateUser
     */
    public function setNotificationMethod($notificationMethod)
    {
        $this->notificationMethod = $notificationMethod;

        return $this;
    }

    /**
     * Get notificationMethod
     *
     * @return string 
     */
    public function getNotificationMethod()
    {
        //return 'email';
        return $this->notificationMethod;
    }

    /**
     * Add jobTitles
     *
     * @param JobTitle $jobTitles
     * @return GraduateUser
     */
    public function addJobTitle(JobTitle $jobTitles)
    {
        $this->jobTitles[] = $jobTitles;

        return $this;
    }

    /**
     * Remove jobTitles
     *
     * @param JobTitle $jobTitles
     */
    public function removeJobTitle(JobTitle $jobTitles)
    {
        $this->jobTitles->removeElement($jobTitles);
    }

    /**
     * Get jobTitles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobTitles()
    {
        return $this->jobTitles;
    }


    /**
     * Set cv
     *
     * @param \Gradually\UtilBundle\Entity\Cv $cv
     * @return GraduateUser
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
