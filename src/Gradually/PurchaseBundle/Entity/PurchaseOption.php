<?php

namespace Gradually\PurchaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseOption
 *
 * @ORM\Table(name="purchase_options")
 * @ORM\Entity
 */
class PurchaseOption
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
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=16)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="postingCredits", type="integer")
     */
    private $postingCredits;

    /**
     * @var integer
     *
     * @ORM\Column(name="searchCredits", type="integer")
     */
    private $searchCredits;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="option")
     */
    private $transactions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set postingCredits
     *
     * @param integer $postingCredits
     * @return PurchaseOption
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
     * @return PurchaseOption
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
     * Add transactions
     *
     * @param \Gradually\PurchaseBundle\Entity\Transaction $transactions
     * @return PurchaseOption
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
     * Set reference
     *
     * @param string $reference
     * @return PurchaseOption
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }
}
