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
     * @ORM\Column(name="purchase_option_id")
     */
    private $purchaseOption;

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
     * Set purchaseOption
     *
     * @param \Gradually\PurchaseBundle\Entity\PurchaseOption $purchaseOption
     * @return Transaction
     */
    public function setOption(\Gradually\PurchaseBundle\Entity\PurchaseOption $purchaseOption = null)
    {
        $this->purchaseOption = $purchaseOption;

        return $this;
    }

    /**
     * Get purchaseOption
     *
     * @return \Gradually\PurchaseBundle\Entity\PurchaseOption 
     */
    public function getOption()
    {
        return $this->purchaseOption;
    }

    /**
     * Set purchaseOption
     *
     * @param string $purchaseOption
     * @return Transaction
     */
    public function setPurchaseOption($purchaseOption)
    {
        $this->purchaseOption = $purchaseOption;

        return $this;
    }

    /**
     * Get purchaseOption
     *
     * @return string 
     */
    public function getPurchaseOption()
    {
        return $this->purchaseOption;
    }
}