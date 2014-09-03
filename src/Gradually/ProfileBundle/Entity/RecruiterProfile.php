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
     * @ORM\OneToMany(targetEntity="\Gradually\PurchaseBundle\Entity\Transaction", mappedBy="recruiter")
     */
    private $transactions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->graduates = new ArrayCollection();
        $this->jobs = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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

    /**
     * Add jobs
     *
     * @param \Gradually\JobBundle\Entity\Job $jobs
     * @return RecruiterProfile
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
     * @return RecruiterProfile
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
}
