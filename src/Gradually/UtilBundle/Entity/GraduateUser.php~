<?php
 
namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GraduateUser
 *
 * @ORM\Entity(repositoryClass="Gradually\UtilBundle\Repository\GraduateUserRepository")
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
     * @ORM\OneToMany(targetEntity="Qualification", mappedBy="graduate")
     */
    private $qualifications;

    /**
     * @ORM\ManyToMany(targetEntity="RecruiterUser", inversedBy="graduates")
     */
    private $recruiters;

    /**
     * @ORM\ManyToMany(targetEntity="School", mappedBy="graduates")
     */
    private $schools;

    /**
     * @ORM\ManyToMany(targetEntity="Course", mappedBy="graduates")
     */
    private $courses;

    /**
     * @ORM\ManyToMany(targetEntity="JobTitleTag", mappedBy="graduates")
     */
    private $jobTitleTags;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="graduate") 
     */
    private $applications;

    /**
     * @var string
     *
     * @ORM\Column(name="notification_method", type="string", length=16)
     */
    private $notificationMethod;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->qualifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recruiters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->universities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobTitleTags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->schools = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param Qualification $qualifications
     * @return GraduateUser
     */
    public function addQualification(Qualification $qualifications)
    {
        $this->qualifications[] = $qualifications;

        return $this;
    }

    /**
     * Remove qualifications
     *
     * @param Qualification $qualifications
     */
    public function removeQualification(Qualification $qualifications)
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
     * Add schoold
     *
     * @param School $school
     * @return GraduateUser
     */
    public function addUniversity(School $school)
    {
        $this->schools[] = $school;

        return $this;
    }

    /**
     * Remove school
     *
     * @param School $school
     */
    public function removeUniversity(School $school)
    {
        $this->schools->removeElement($school);
    }

    /**
     * Get school
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUniversities()
    {
        return $this->schools;
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
        return 'email';
        return $this->notificationMethod;
    }

    /**
     * Add jobTitleTags
     *
     * @param JobTitleTag $jobTitleTags
     * @return GraduateUser
     */
    public function addJobTitleTag(JobTitleTag $jobTitleTags)
    {
        $this->jobTitleTags[] = $jobTitleTags;

        return $this;
    }

    /**
     * Remove jobTitleTags
     *
     * @param JobTitleTag $jobTitleTags
     */
    public function removeJobTitleTag(JobTitleTag $jobTitleTags)
    {
        $this->jobTitleTags->removeElement($jobTitleTags);
    }

    /**
     * Get jobTitleTags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobTitleTags()
    {
        return $this->jobTitleTags;
    }

    /**
     * Add schools
     *
     * @param \Gradually\UtilBundle\Entity\School $schools
     * @return GraduateUser
     */
    public function addSchool(\Gradually\UtilBundle\Entity\School $schools)
    {
        $this->schools[] = $schools;

        return $this;
    }

    /**
     * Remove schools
     *
     * @param \Gradually\UtilBundle\Entity\School $schools
     */
    public function removeSchool(\Gradually\UtilBundle\Entity\School $schools)
    {
        $this->schools->removeElement($schools);
    }

    /**
     * Get schools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchools()
    {
        return $this->schools;
    }

    /**
     * Add courses
     *
     * @param \Gradually\UtilBundle\Entity\Course $courses
     * @return GraduateUser
     */
    public function addCourse(\Gradually\UtilBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \Gradually\UtilBundle\Entity\Course $courses
     */
    public function removeCourse(\Gradually\UtilBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }
}
