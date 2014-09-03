<?php

namespace Gradually\PurchaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transactions")
 * @ORM\Entity
 */
class Transaction
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Gradually\ProfileBundle\Entity\RecruiterProfile", inversedBy="transactions")
     */
    private $recruiter;

    /**
     * @ORM\ManyToOne(targetEntity="PurchaseOption", inversedBy="transactions")
     */
    private $option;

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
     * Set recruiter
     *
     * @param \Gradually\ProfileBundle\Entity\RecruiterProfile $recruiter
     * @return Transaction
     */
    public function setRecruiter(\Gradually\ProfileBundle\Entity\RecruiterProfile $recruiter = null)
    {
        $this->recruiter = $recruiter;

        return $this;
    }

    /**
     * Get recruiter
     *
     * @return \Gradually\ProfileBundle\Entity\RecruiterProfile 
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * Set option
     *
     * @param string $option
     * @return Transaction
     */
    public function setOption($option)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return string 
     */
    public function getOption()
    {
        return $this->option;
    }
}
