<?php
 
namespace Gradually\UtilBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * RecruiterUser
 *
 * @ORM\Entity(repositoryClass="Gradually\UtilBundle\Repository\RecruiterUserRepository")
 */
class RecruiterUser extends User
{
    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=128)
     */
    protected $companyName;

    /**
     * @ORM\ManyToMany(targetEntity="GraduateUser", mappedBy="recruiters")
     */
    private $graduates;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="recruiter")
     */
    private $jobs;

    /**
     * @ORM\Column(name="posting_credits", type="integer")
     */
    private $postingCredits;

    /**
     * @ORM\Column(name="premium_credits", type="integer")
     */
    private $premiumCredits;

    /**
     * @ORM\Column(name="search_credits", type="integer")
     */
    private $searchCredits;

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
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return RecruiterUser
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set postingCredits
     *
     * @param integer $postingCredits
     * @return RecruiterUser
     */
    public function setPostingCredits($postingCredits)
    {
        $this->postingCredits = $postingCredits;

        return $this;
    }

    /**
     * Get postingCredits
     *
     * @return integer 
     */
    public function getPostingCredits()
    {
        return $this->postingCredits;
    }

    /**
     * Set searchCredits
     *
     * @param integer $searchCredits
     * @return RecruiterUser
     */
    public function setSearchCredits($searchCredits)
    {
        $this->searchCredits = $searchCredits;

        return $this;
    }

    /**
     * Get searchCredits
     *
     * @return integer 
     */
    public function getSearchCredits()
    {
        return $this->searchCredits;
    }

    /**
     * Add graduates
     *
     * @param GraduateUser $graduates
     * @return RecruiterUser
     */
    public function addGraduate(GraduateUser $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param GraduateUser $graduates
     */
    public function removeGraduate(GraduateUser $graduates)
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

    /**
     * Add jobs
     *
     * @param Job $jobs
     * @return RecruiterUser
     */
    public function addJob(Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param Job $jobs
     */
    public function removeJob(Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return parent::TYPE_RECRUITER;
    }

    /**
     * Set notificationMethod
     *
     * @param string $notificationMethod
     * @return RecruiterUser
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
     * Set premiumCredits
     *
     * @param integer $premiumCredits
     * @return RecruiterUser
     */
    public function setPremiumCredits($premiumCredits)
    {
        $this->premiumCredits = $premiumCredits;

        return $this;
    }

    /**
     * Get premiumCredits
     *
     * @return integer 
     */
    public function getPremiumCredits()
    {
        return $this->premiumCredits;
    }
}
