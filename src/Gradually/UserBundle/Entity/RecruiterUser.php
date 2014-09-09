<?php
 
namespace Gradually\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * RecruiterUser
 *
 * @ORM\Entity
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
     * @ORM\OneToMany(targetEntity="\Gradually\JobBundle\Entity\Job", mappedBy="recruiter")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="\Gradually\PurchaseBundle\Entity\Transaction", mappedBy="recruiter")
     */
    private $transactions;

    /**
     * @ORM\Column(name="posting_credits", type="integer")
     */
    private $postingCredits;

    /**
     * @ORM\Column(name="search_credits", type="integer")
     */
    private $searchCredits;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->graduates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setPostingCredits(0);
        $this->setSearchCredits(0);
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
     * @param \Gradually\UserBundle\Entity\GraduateUser $graduates
     * @return RecruiterUser
     */
    public function addGraduate(\Gradually\UserBundle\Entity\GraduateUser $graduates)
    {
        $this->graduates[] = $graduates;

        return $this;
    }

    /**
     * Remove graduates
     *
     * @param \Gradually\UserBundle\Entity\GraduateUser $graduates
     */
    public function removeGraduate(\Gradually\UserBundle\Entity\GraduateUser $graduates)
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
     * @param \Gradually\JobBundle\Entity\Job $jobs
     * @return RecruiterUser
     */
    public function addJob(\Gradually\JobBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Gradually\JobBundle\Entity\Job $jobs
     */
    public function removeJob(\Gradually\JobBundle\Entity\Job $jobs)
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
     * Add transactions
     *
     * @param \Gradually\PurchaseBundle\Entity\Transaction $transactions
     * @return RecruiterUser
     */
    public function addTransaction(\Gradually\PurchaseBundle\Entity\Transaction $transactions)
    {
        $this->transactions[] = $transactions;

        return $this;
    }

    /**
     * Remove transactions
     *
     * @param \Gradually\PurchaseBundle\Entity\Transaction $transactions
     */
    public function removeTransaction(\Gradually\PurchaseBundle\Entity\Transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransactions()
    {
        return $this->transactions;
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
}
